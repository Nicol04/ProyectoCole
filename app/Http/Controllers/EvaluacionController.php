<?php

namespace App\Http\Controllers;

use App\Models\Evaluacion;
use App\Models\Sesion;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\Archivo;
use App\Models\AulaCurso;
use App\Models\IntentoEvaluacion;
use App\Models\ExamenPregunta;

use Illuminate\Support\Facades\DB;

class EvaluacionController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $roleId = $user->roles->first()?->id ?? null;

        $evaluacionesEnProgreso = collect();
        $evaluacionesNoIniciadas = collect();

        if ($roleId == 3) {
            $userId = $user->id;
            $aulaIds = $user->aulas->pluck('id');
            $aulaCursoIds = AulaCurso::whereIn('aula_id', $aulaIds)->pluck('id');
            $sesionIds = Sesion::whereIn('aula_curso_id', $aulaCursoIds)->pluck('id');

            // FILTRO POR CURSO
            $cursoId = $request->curso;
            $evaluacionesQuery = Evaluacion::whereIn('sesion_id', $sesionIds)
                ->has('preguntas')
                ->with([
                    'sesion.aulaCurso.curso',
                    'intentos' => function ($q) use ($userId) {
                        $q->where('user_id', $userId);
                    }
                ]);
            if ($cursoId) {
                $evaluacionesQuery->whereHas('sesion.aulaCurso', function ($q) use ($cursoId) {
                    $q->where('curso_id', $cursoId);
                });
            }
            $evaluaciones = $evaluacionesQuery->paginate(12)->withQueryString();

            $evaluacionesEnProgreso = collect();
            $evaluacionesNoIniciadas = collect();
            // CLASIFICACIÓN POR ESTADO
            foreach ($evaluaciones as $evaluacion) {
                $intentos = $evaluacion->intentos;
                $tieneEnProgreso = $intentos->contains(function($intento) {
                    return $intento->estado === 'en progreso' && is_null($intento->fecha_fin);
                });

                if ($tieneEnProgreso) {
                    $evaluacionesEnProgreso->push($evaluacion);
                } elseif ($intentos->isEmpty()) {
                    $evaluacionesNoIniciadas->push($evaluacion);
                }
            }

            // FILTRO POR ESTADO
            $estado = $request->estado;
            if ($estado == 'sin_intento') {
                $evaluacionesEnProgreso = collect();
            } elseif ($estado == 'en_progreso') {
                $evaluacionesNoIniciadas = collect();
            }

            // Para el sidebar: cursos con conteo de evaluaciones pendientes
            $cursos = $user->aulas->flatMap->cursos->unique('id');
            foreach ($cursos as $curso) {
                $curso->evaluaciones_count = $evaluaciones->filter(function ($ev) use ($curso) {
                    return $ev->sesion->aulaCurso->curso->id == $curso->id;
                })->count();
            }
        } else {
            $cursos = collect();
        }

        return view('panel.evaluaciones.index', compact(
            'evaluaciones',
            'evaluacionesEnProgreso',
            'evaluacionesNoIniciadas',
            'roleId',
            'cursos'
        ));
    }
    public function actualizar(Request $request, $id)
    {
        $evaluacion = Evaluacion::findOrFail($id);

        if ($request->accion === 'imagen' && $request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('evaluaciones', 'public');
            $evaluacion->imagen_url = $path;
            $evaluacion->texto = null;
        } elseif ($request->accion === 'texto') {
            $evaluacion->texto = $request->input('texto');
            $evaluacion->imagen_url = null;
        }

        $evaluacion->save();

        // Devuelve respuesta JSON para AJAX
        return response()->json([
            'success' => true,
            'evaluacion_id' => $evaluacion->id,
            'imagen_url' => $evaluacion->imagen_url,
            'texto' => $evaluacion->texto,
        ]);
    }
    public function create()
    {
        $user = Auth::user();
        $cursos = collect();

        foreach ($user->aulas as $aula) {
            foreach ($aula->cursos as $curso) {
                $cursos->push($curso);
            }
        }
        $cursos = $cursos->unique('id');
        $aula_curso_id = null;
        $sesion_id = null;
        $curso_nombre = null;
        $sesion_titulo = null;
        $origen = 'general';

        return view('panel.evaluaciones.create', compact(
            'cursos',
            'aula_curso_id',
            'sesion_id',
            'curso_nombre',
            'sesion_titulo',
            'origen'
        ));
    }

    public function create_sesion(Request $request)
    {
        $user = Auth::user()->load('aulas.cursos');
        $cursos = collect();

        foreach ($user->aulas as $aula) {
            foreach ($aula->cursos as $curso) {
                $cursos->push($curso);
            }
        }

        $cursos = $cursos->unique('id');

        $aula_curso_id = $request->input('aula_curso_id');
        $sesion_id = $request->input('sesion_id');
        $curso_nombre = null;
        $sesion_titulo = null;
        $curso_id = null;

        if ($sesion_id) {
            $sesion = Sesion::with('aulaCurso.curso')->find($sesion_id);
            if ($sesion) {
                $sesion_titulo = $sesion->titulo;
                if ($sesion->aulaCurso && $sesion->aulaCurso->curso) {
                    $curso_nombre = $sesion->aulaCurso->curso->curso;
                    $aula_curso_id = $sesion->aulaCurso->id;
                    $curso_id = $sesion->aulaCurso->curso->id;
                }
            }
        }

        $origen = 'sesion';
        return view('panel.evaluaciones.create', compact(
            'cursos',
            'aula_curso_id',
            'sesion_id',
            'curso_nombre',
            'sesion_titulo',
            'origen',
            'curso_id'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sesion_id' => 'required|exists:sesions,id',
            'titulo' => 'required|string|max:255',
            'cantidad_preguntas' => 'required|integer|min:2|max:20',
            'cantidad_intentos' => 'nullable|integer|min:1|max:10',
            'es_supervisado' => 'nullable|boolean',
        ], [
            'sesion_id.required' => 'La sesión es obligatoria.',
            'sesion_id.exists' => 'La sesión seleccionada no es válida.',
            'titulo.required' => 'El título es obligatorio.',
            'titulo.max' => 'El título no debe superar los 255 caracteres.',
            'cantidad_preguntas.required' => 'La cantidad de preguntas es obligatoria.',
            'cantidad_preguntas.min' => 'Debe haber al menos 2 preguntas.',
            'cantidad_preguntas.max' => 'No puede haber más de 20 preguntas.',
            'cantidad_intentos.min' => 'Debe haber al menos 1 intento.',
            'cantidad_intentos.max' => 'No puede haber más de 10 intentos.',
        ]);
        $cantidad_intentos = $validated['cantidad_intentos'] ?? 1;
        DB::beginTransaction();
        try {

            $evaluacion = Evaluacion::create([
                'sesion_id' => $validated['sesion_id'],
                'user_id' => Auth::id(),
                'es_supervisado' => $request->has('es_supervisado') ? 1 : 0,
                'titulo' => $validated['titulo'],
                'fecha_creacion' => now(),
                'cantidad_preguntas' => $validated['cantidad_preguntas'],
                'cantidad_intentos' => $cantidad_intentos,
            ]);

            DB::commit();

            return redirect()->route('evaluaciones.generarExamen', $evaluacion->id)
                ->with('mensaje', 'Evaluación creada correctamente.')
                ->with('icono', 'success');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withErrors('Error al crear la evaluación. Inténtalo de nuevo.');
        }
    }
    public function getSesionesPorCurso($cursoId)
    {
        $sesiones = Sesion::whereHas('aulaCurso', function ($query) use ($cursoId) {
            $query->where('curso_id', $cursoId);
        })->get();
        return response()->json($sesiones);
    }

    public function destroy($id)
    {
        $evaluacion = Evaluacion::findOrFail($id);
        $evaluacion->preguntas()->delete();
        $evaluacion->delete();

        return redirect()->back()
            ->with('mensaje', 'Evaluación eliminada correctamente.')
            ->with('icono', 'success');
    }
    public function iniciar($evaluacion_id)
    {
        $evaluacion = Evaluacion::findOrFail($evaluacion_id);
        $user = Auth::user();
        $intentosActuales = IntentoEvaluacion::where('evaluacion_id', $evaluacion_id)
            ->where('user_id', $user->id)
            ->count();
        if ($intentosActuales >= $evaluacion->cantidad_intentos) {
            return redirect()->back()->with('error', 'Ya alcanzaste el número máximo de intentos.');
        }
        // Crear nuevo intento
        $intento = IntentoEvaluacion::create([
            'evaluacion_id' => $evaluacion->id,
            'user_id' => $user->id,
            'fecha_inicio' => now(),
            'estado' => 'en progreso',
        ]);
        // Enviar a vista con el intento_id
        return redirect()->route('evaluaciones.examen', [
            'evaluacion_id' => $evaluacion_id,
            'mostrar_iframe' => 1,
            'intento_id' => $intento->id
        ]);
    }
}
