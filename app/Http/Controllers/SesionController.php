<?php

namespace App\Http\Controllers;

use App\Models\AulaCurso;
use App\Models\Capacidad;
use App\Models\Competencia;
use App\Models\Desempeno;
use App\Models\Sesion;
use App\Models\SesionDetalle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SesionController extends Controller
{
    public function create(Request $request)
    {
        $user = Auth::user();
        $cursos = collect();

        // Obtener todos los cursos relacionados al docente
        foreach ($user->aulas as $aula) {
            foreach ($aula->cursos as $curso) {
                $cursos->push($curso);
            }
        }
        $cursos = $cursos->unique('id');

        // Variables inicializadas
        $aula_curso_id = $request->query('aula_curso_id'); // Obtener el aula_curso_id si existe
        $curso = null;
        $competencias = collect(); // Inicializar como colección vacía
        $origen = 'general';
        $disableCursoSelect = false;
        // Si se selecciona un aula_curso_id, obtener el curso y sus competencias
        if ($aula_curso_id) {
            $aulaCurso = AulaCurso::findOrFail($aula_curso_id); // Buscar el aula_curso
            $curso = $aulaCurso->curso; // Obtener el curso relacionado
            $competencias = Competencia::where('curso_id', $curso->id)
                ->select('id', 'nombre', 'descripcion')
                ->get(); // Obtener competencias del curso
            $disableCursoSelect = true;
        }

        return view('panel.sesiones.create', compact(
            'cursos',
            'aula_curso_id',
            'curso',
            'competencias',
            'origen',
            'disableCursoSelect'
        ));
    }
    public function createSession(Request $request)
    {
        $user = Auth::user()->load('aulas.cursos');
        $cursos = collect();

        // Obtener todos los cursos relacionados al docente
        foreach ($user->aulas as $aula) {
            foreach ($aula->cursos as $curso) {
                $cursos->push($curso);
            }
        }

        $cursos = $cursos->unique('id');

        // Variables inicializadas
        $aula_curso_id = $request->input('aula_curso_id');
        $curso_id = null;
        $curso_nombre = null;
        $competencias = collect(); // Inicializar como colección vacía
        $disableCursoSelect = false;
        // Si se selecciona un aula_curso_id, obtener el curso y sus competencias
        if ($aula_curso_id) {
            $aulaCurso = AulaCurso::with('curso')->find($aula_curso_id);

            if ($aulaCurso && $aulaCurso->curso) {
                $curso_id = $aulaCurso->curso->id;
                $curso_nombre = $aulaCurso->curso->curso;

                // Obtener competencias relacionadas al curso
                $competencias = Competencia::where('curso_id', $curso_id)
                    ->select('id', 'nombre', 'descripcion')
                    ->get();
            }
        }

        $origen = 'sesion';

        return view('panel.sesiones.create', compact(
            'cursos',
            'aula_curso_id',
            'curso_id',
            'curso_nombre',
            'competencias',
            'origen',
            'disableCursoSelect'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'proposito_sesion' => 'required|string',
            'fecha' => 'required|date',
            'tiempo_estimado' => 'required|integer|min:1',
            'aula_curso_id' => 'required|exists:aula_curso,id',
            // Campos pedagógicos
            'competencias' => 'nullable|array',
            'capacidades' => 'nullable|array',
            'desempenos' => 'nullable|array',
            'evidencia' => 'nullable|string',
            'instrumento' => 'nullable|string',
        ]);

        $validated['dia'] = $request->input('dia');
        $validated['docente_id'] = Auth::id();

        // Crear la sesión
        $sesion = Sesion::create($validated);

        // Crear el detalle pedagógico si hay datos
        if ($request->has('competencias') || $request->has('capacidades') || $request->has('desempenos')) {
            SesionDetalle::create([
                'sesion_id' => $sesion->id,
                'competencias' => $request->competencias ?? [],
                'capacidades' => $request->capacidades ?? [],
                'desempenos' => $request->desempenos ?? [],
                'evidencia' => $request->evidencia,
                'instrumento' => $request->instrumento,
            ]);
        }

        return redirect()->route('sesiones.show', $sesion->id)
            ->with('mensaje', 'Sesión creada exitosamente')
            ->with('icono', 'success');
    }

    public function show($id)
    {
        $sesion = Sesion::with(['aulaCurso.curso', 'evaluaciones', 'detalle'])->findOrFail($id);
        return view('panel.sesiones.show', compact('sesion'));
    }

    public function edit($id)
    {
        $sesion = Sesion::with('detalle')->findOrFail($id);
        $curso = $sesion->aulaCurso->curso;

        $competencias = DB::table('competencias')
            ->where('curso_id', $curso->id)
            ->select('id', 'nombre', 'descripcion', 'curso_id')
            ->get();

        return view('panel.sesiones.edit', compact('sesion', 'competencias'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'fecha' => 'required|date',
            'titulo' => 'required|string',
            'proposito_sesion' => 'required|string',
            'tiempo_estimado' => 'required|integer|min:1',
            'competencias' => 'nullable|array',
            'capacidades' => 'nullable|array',
            'desempenos' => 'nullable|array',
            'evidencia' => 'nullable|string',
            'instrumento' => 'nullable|string',
        ]);

        $sesion = Sesion::findOrFail($id);
        $fecha = Carbon::parse($request->fecha);
        $dia = ucfirst($fecha->locale('es')->isoFormat('dddd'));

        $sesion->update([
            'fecha' => $request->fecha,
            'dia' => $dia,
            'titulo' => $request->titulo,
            'proposito_sesion' => $request->proposito_sesion,
            'tiempo_estimado' => $request->tiempo_estimado,
        ]);

        // Actualizar o crear detalle pedagógico
        $detalle = $sesion->detalle;
        $datosDetalle = [
            'competencias' => $request->competencias ?? [],
            'capacidades' => $request->capacidades ?? [],
            'desempenos' => $request->desempenos ?? [],
            'evidencia' => $request->evidencia,
            'instrumento' => $request->instrumento,
        ];

        if ($detalle) {
            $detalle->update($datosDetalle);
        } else {
            $datosDetalle['sesion_id'] = $sesion->id;
            SesionDetalle::create($datosDetalle);
        }

        return redirect()->route('sesiones.show', $id)
            ->with('mensaje', 'Sesión actualizada exitosamente')
            ->with('icono', 'success');
    }

    public function destroy($id)
    {
        $sesion = Sesion::findOrFail($id);

        // Eliminar detalle pedagógico
        $sesion->detalle?->delete();

        foreach ($sesion->evaluaciones as $evaluacion) {
            $evaluacion->preguntas()->delete();
            $evaluacion->delete();
        }
        $sesion->delete();
        return redirect()->back()
            ->with('mensaje', 'Sesión y sus evaluaciones eliminadas.')
            ->with('icono', 'success');
    }

    public function getCompetenciasByCurso($cursoId)
    {
        try {
            $competencias = Competencia::where('curso_id', $cursoId)
                ->select('id', 'nombre')
                ->get();

            return response()->json($competencias);
        } catch (\Exception $e) {
            Log::error("Error al obtener competencias: " . $e->getMessage());
            return response()->json(['error' => 'Error al cargar competencias'], 500);
        }
    }


    public function getCapacidadesByCompetencia($competenciaId)
    {
        try {
            $capacidades = Capacidad::where('competencia_id', $competenciaId)
                ->select('id', 'nombre')
                ->get();

            return response()->json($capacidades);
        } catch (\Exception $e) {
            Log::error("Error al obtener capacidades: " . $e->getMessage());
            return response()->json(['error' => 'Error al cargar capacidades'], 500);
        }
    }

    public function getDesempenosPorCompetenciaYGrado(Request $request)
    {
        try {
            $user = Auth::user();

            // Obtener el aula_id del usuario autenticado
            $aulaId = $user->usuario_aulas()->pluck('aula_id')->first();

            // Determinar el grado a partir del aula_id
            $grado = $this->getGradoFromAulaId($aulaId);

            if (!$grado) {
                return response()->json(['error' => 'No se pudo determinar el grado del usuario.'], 400);
            }

            // Validar competencia_id
            $competenciaId = $request->input('competencia_id');
            if (!$competenciaId) {
                return response()->json(['error' => 'No se ha seleccionado una competencia.'], 400);
            }

            // 🔥 Aquí viene la magia:
            $desempenos = Desempeno::whereHas('capacidad', function ($query) use ($competenciaId) {
                $query->where('competencia_id', $competenciaId);
            })
                ->where('grado', $grado) // filtrar por el grado correspondiente
                ->select('id', 'descripcion', 'capacidad_id')
                ->get();

            return response()->json($desempenos);
        } catch (\Exception $e) {
            Log::error("Error al obtener desempeños: " . $e->getMessage());
            return response()->json(['error' => 'Error al cargar desempeños'], 500);
        }
    }


    private function getGradoFromAulaId($aulaId)
    {
        if ($aulaId >= 22 && $aulaId <= 25) {
            return '1° grado';
        } elseif ($aulaId >= 18 && $aulaId <= 21) {
            return '2° grado';
        } elseif ($aulaId >= 14 && $aulaId <= 17) {
            return '3° grado';
        } elseif ($aulaId >= 10 && $aulaId <= 13) {
            return '4° grado';
        } elseif ($aulaId >= 1 && $aulaId <= 4) {
            return '5° grado';
        } elseif ($aulaId >= 5 && $aulaId <= 9) {
            return '6° grado';
        }

        return null;
    }
}
