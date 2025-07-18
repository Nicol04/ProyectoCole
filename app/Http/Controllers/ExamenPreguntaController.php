<?php

namespace App\Http\Controllers;

use App\Models\Archivo;
use App\Models\Calificacion;
use App\Models\Evaluacion;
use App\Models\ExamenPregunta;
use App\Models\IntentoEvaluacion;
use App\Models\Respuesta_estudiante;
use App\Models\Sesion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamenPreguntaController extends Controller
{

    public function show($evaluacion_id, Request $request)
    {
        $evaluacion = Evaluacion::findOrFail($evaluacion_id);
        $examenPregunta = ExamenPregunta::where('evaluacion_id', $evaluacion_id)->first();
        $preguntas_json = $examenPregunta ? json_decode($examenPregunta->examen_json, true) : [];
        $intentos = null;
        $ultimoIntento = null;
        $intentosConRespuestas = [];
        $estudiantes = [];
        $intentoEnProceso = null;

        if (Auth::check()) {
            $roleId = Auth::user()->roles->first()?->id;

            // Para estudiantes
            if ($roleId == 3) {
                $user = Auth::user();
                $intentosActuales = IntentoEvaluacion::where('evaluacion_id', $evaluacion_id)
                    ->where('user_id', $user->id)
                    ->count();
                $intentos = max(0, $evaluacion->cantidad_intentos - $intentosActuales);

                $ultimoIntento = IntentoEvaluacion::where('evaluacion_id', $evaluacion_id)
                    ->where('user_id', $user->id)
                    ->orderByDesc('created_at')
                    ->first();

                $intentosConRespuestas = IntentoEvaluacion::where('evaluacion_id', $evaluacion_id)
                    ->where('user_id', $user->id)
                    ->orderByDesc('created_at')
                    ->get()
                    ->map(function ($intento) use ($user) {
                        $respuesta = Respuesta_estudiante::where('intento_id', $intento->id)
                            ->where('user_id', $user->id)
                            ->first();
                        $calificacion = Calificacion::where('intento_id', $intento->id)->first();
                        return [
                            'intento' => $intento,
                            'respuesta_json' => $respuesta ? $respuesta->respuesta_json : null,
                            'fecha_respuesta' => $respuesta ? $respuesta->fecha_respuesta : null,
                            'calificacion' => $calificacion,
                        ];
                    });
                $intentoEnProceso = IntentoEvaluacion::where('evaluacion_id', $evaluacion_id)
                    ->where('user_id', $user->id)
                    ->where('estado', 'en progreso')
                    ->exists();
            }

            // Para docentes - Con filtros, búsqueda y paginación
            if ($roleId == 2) {
                // Obtener parámetros de búsqueda y filtros
                $search = $request->get('search');
                $estadoFiltro = $request->get('estado_filtro');

                // Obtener el aula asignada al docente
                $user = Auth::user();
                $aula = $user->aulas()->first(); // Asumiendo que el docente tiene una relación con aulas
                $estudiantes = collect();

                if ($aula) {
                    // Query base para estudiantes del aula
                    $estudiantesQuery = $aula->users()
                        ->whereHas('roles', function ($q) {
                            $q->where('id', 3); // Solo estudiantes
                        })
                        ->with([
                            'persona',
                            'avatar',
                            'intentos' => function ($q) use ($evaluacion_id) {
                                $q->where('evaluacion_id', $evaluacion_id)
                                    ->with('calificacion')
                                    ->orderBy('created_at');
                            }
                        ]);

                    // Aplicar filtro de búsqueda por nombre o apellido
                    if ($search) {
                        $estudiantesQuery->whereHas('persona', function ($q) use ($search) {
                            $q->where('nombre', 'LIKE', "%{$search}%")
                                ->orWhere('apellido', 'LIKE', "%{$search}%");
                        });
                    }

                    // Aplicar filtro por estado de calificación
                    if ($estadoFiltro && in_array($estadoFiltro, ['APROBADO', 'DESAPROBADO'])) {
                        $estudiantesQuery->whereHas('intentos', function ($q) use ($evaluacion_id, $estadoFiltro) {
                            $q->where('evaluacion_id', $evaluacion_id)
                                ->whereHas('calificacion', function ($subQ) use ($estadoFiltro) {
                                    $subQ->where('estado', $estadoFiltro);
                                });
                        });
                    }

                    // Paginación de los estudiantes
                    $estudiantes = $estudiantesQuery->paginate(10)->appends($request->query());
                }
            }
        }

        return view('panel.examenes.show', compact(
            'evaluacion',
            'preguntas_json',
            'intentos',
            'ultimoIntento',
            'intentosConRespuestas',
            'estudiantes',
            'intentoEnProceso'
        ));
    }

    public function generarExamen($evaluacion_id)
    {
        $evaluacion = Evaluacion::findOrFail($evaluacion_id);
        $sesion = Sesion::find($evaluacion->sesion_id);

        return view('panel.ia.generar_preguntas', [
            'evaluacion_id' => $evaluacion->id,
            'cantidad_preguntas' => $evaluacion->cantidad_preguntas,
            'titulo' => $sesion ? $sesion->titulo : '',
            'objetivo' => $sesion ? $sesion->objetivo : '',
            'actividades' => $sesion ? $sesion->actividades : '',
        ]);
    }
    public function formulario(Request $request)
    {
        return view('panel.examenes.formulario', [
            'evaluacion_id' => $request->input('evaluacion_id'),
            'cantidad_preguntas' => $request->input('cantidad_preguntas'),
            'titulo' => $request->input('titulo'),
            'objetivo' => $request->input('objetivo'),
            'actividades' => $request->input('actividades'),
        ]);
    }
    public function renderizar(Request $request)
    {
        $evaluacion_id = $request->input('evaluacion_id');
        $cantidad_preguntas = $request->input('cantidad_preguntas');
        $titulo = $request->input('titulo');

        $evaluacion = Evaluacion::with('preguntas')->findOrFail($evaluacion_id);
        $examenPregunta = $evaluacion->preguntas->first();

        if (!$examenPregunta) {
            return redirect()->back()->with('error', 'No se encontraron preguntas para esta evaluación.');
        }

        $preguntas_json = json_decode($examenPregunta->examen_json, true);

        return view('panel.examenes.renderizar', [
            'evaluacion_id' => $evaluacion_id,
            'cantidad_preguntas' => $cantidad_preguntas,
            'titulo' => $titulo,
            'preguntas_json' => $preguntas_json,
            'evaluacion' => $evaluacion,
            'examenPregunta' => $examenPregunta
        ]);
    }

    public function store(Request $request)
    {
        $evaluacion_id = $request->input('evaluacion_id');
        $examen_json = $request->input('jsonFinal');

        $request->validate([
            'evaluacion_id' => 'required|integer|exists:evaluacions,id',
            'jsonFinal' => 'required|json',
        ]);

        $examenPregunta = new ExamenPregunta();
        $examenPregunta->evaluacion_id = $evaluacion_id;
        $examenPregunta->examen_json = $examen_json;
        $examenPregunta->save();
        $evaluacion = Evaluacion::findOrFail($evaluacion_id);

        if ($request->has('visible')) {
            $evaluacion->visible = $request->boolean('visible');
        } else {
            $evaluacion->visible = false;
        }
        $evaluacion->save();

        return response()->view('panel.iframe_redirect', [
            'url' => route('evaluaciones.examen', ['evaluacion_id' => $evaluacion_id]),
            'mensaje' => 'Examen guardado correctamente.',
            'icono' => 'success'
        ]);
    }
    public function edit($id, Request $request)
    {
        $examenPregunta = ExamenPregunta::findOrFail($id);
        $preguntas_json = json_decode($examenPregunta->examen_json, true);
        $evaluacion_id = $request->query('evaluacion_id');
        $evaluacion = Evaluacion::find($evaluacion_id);
        return view('panel.examenes.edit', compact('examenPregunta', 'preguntas_json', 'evaluacion', 'evaluacion_id'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jsonFinal' => 'required|json',
            'evaluacion_id' => 'required|integer|exists:evaluacions,id',
            'cantidad_intentos' => 'required|integer|min:1|max:10',
        ]);

        $examenPregunta = ExamenPregunta::findOrFail($id);
        $examenPregunta->examen_json = $request->input('jsonFinal');
        $examenPregunta->save();

        // Actualiza la cantidad de intentos en la evaluación
        $evaluacion = Evaluacion::findOrFail($request->input('evaluacion_id'));
        $evaluacion->cantidad_intentos = $request->input('cantidad_intentos');
        $evaluacion->visible = $request->boolean('visible');
        $evaluacion->save();

        // Redirige al show del examen en la página padre usando iframe_redirect
        return response()->view('panel.iframe_redirect', [
            'url' => route('evaluaciones.examen', ['evaluacion_id' => $evaluacion->id]),
            'mensaje' => 'Examen actualizado correctamente.',
            'icono' => 'success'
        ]);
    }
    public function mostrarExamenEstudiante(Request $request)
    {
        $evaluacion_id = $request->query('evaluacion_id');
        $intento_id = $request->query('intento_id');
        $evaluacion = \App\Models\Evaluacion::findOrFail($evaluacion_id);
        $examenPregunta = \App\Models\ExamenPregunta::where('evaluacion_id', $evaluacion_id)->first();
        $preguntas_json = $examenPregunta ? json_decode($examenPregunta->examen_json, true) : [];
        return view('panel.examenes.estudiantes', compact('evaluacion', 'preguntas_json', 'intento_id', 'examenPregunta'));
    }
}
