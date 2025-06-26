<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class CalificacionController extends Controller
{
    public function index($id)
    {
        $estudiante = User::with(['persona', 'avatar'])->findOrFail($id);

        // 1. Obtener todas las aulas del estudiante
        $aulas = $estudiante->aulas()->pluck('aulas.id');
        $cursosAula = \App\Models\Curso::whereIn(
            'id',
            \App\Models\AulaCurso::whereIn('aula_id', $aulas)->pluck('curso_id')
        )->get();
        // 2. Obtener los aula_curso_id de esas aulas
        $aulaCursoIds = \App\Models\AulaCurso::whereIn('aula_id', $aulas)->pluck('id');
        // 3. Obtener las sesiones de esos aula_curso
        $sesionIds = \App\Models\Sesion::whereIn('aula_curso_id', $aulaCursoIds)->pluck('id');
        // 4. Obtener las evaluaciones de esas sesiones
        $evaluaciones = \App\Models\Evaluacion::whereIn('sesion_id', $sesionIds)->get();

        $porCurso = []; // Aquí agrupamos por curso

        foreach ($evaluaciones as $evaluacion) {
            // Solo intentos FINALIZADOS del estudiante
            $intentos = $evaluacion->intentos()
                ->where('user_id', $estudiante->id)
                ->where('estado', 'finalizado')
                ->with('calificacion')
                ->get();

            // Mejor intento (mayor puntaje_total)
            $mejorIntento = $intentos->sortByDesc(function ($intento) {
                return $intento->calificacion->puntaje_total ?? 0;
            })->first();

            if ($mejorIntento && $mejorIntento->calificacion) {
                $cursoNombre = $evaluacion->sesion->aulaCurso->curso->curso ?? 'Sin curso';
                if (!isset($porCurso[$cursoNombre])) {
                    $porCurso[$cursoNombre] = [
                        'porcentajes' => [],
                        'estados' => [],
                        'cantidad' => 0,
                    ];
                }
                // Guarda el porcentaje y el estado de la calificación
                $porCurso[$cursoNombre]['porcentajes'][] = $mejorIntento->calificacion->porcentaje;
                $porCurso[$cursoNombre]['estados'][] = $mejorIntento->calificacion->estado;
                $porCurso[$cursoNombre]['cantidad']++;
            }
        }

        // Calcula promedios por curso
        $promediosPorCurso = [];
        foreach ($cursosAula as $curso) {
            $nombre = $curso->curso;
            if (isset($porCurso[$nombre]) && $porCurso[$nombre]['cantidad'] > 0) {
                $promedioPorcentaje = round(array_sum($porCurso[$nombre]['porcentajes']) / $porCurso[$nombre]['cantidad'], 2);

                // Estado y letra según porcentaje
                if ($promedioPorcentaje >= 70) {
                    $estado = 'Aprobado';
                    $letra = 'A';
                } elseif ($promedioPorcentaje >= 50) {
                    $estado = 'Intermedio';
                    $letra = 'B';
                } else {
                    $estado = 'Desaprobado';
                    $letra = 'C';
                }

                $promediosPorCurso[$nombre] = [
                    'promedio_porcentaje' => $promedioPorcentaje,
                    'estado' => $estado,
                    'letra' => $letra,
                    'cantidad' => $porCurso[$nombre]['cantidad'],
                ];
            } else {
                $promediosPorCurso[$nombre] = [
                    'promedio_porcentaje' => 0,
                    'estado' => 'Sin datos',
                    'letra' => '-',
                    'cantidad' => 0,
                ];
            }
        }


        // Si quieres el promedio general, puedes mantener tu lógica anterior
        $sumaPuntajes = array_sum(array_column($porCurso, 'puntaje_total'));
        $sumaMaximos = array_sum(array_column($porCurso, 'puntaje_maximo'));
        $cantidad = array_sum(array_column($porCurso, 'cantidad'));
        $promedio = $cantidad > 0 ? round($sumaPuntajes / $cantidad, 2) : 0;
        $promedioPorcentaje = $sumaMaximos > 0 ? round(($sumaPuntajes / $sumaMaximos) * 100, 2) : 0;

        foreach ($cursosAula as $curso) {
            $nombre = $curso->curso;
            if (!isset($promediosPorCurso[$nombre])) {
                $promediosPorCurso[$nombre] = [
                    'promedio' => 0,
                    'porcentaje' => 0,
                    'cantidad' => 0,
                ];
            }
        }
        return view('panel.calificaciones.index', compact(
            'estudiante',
            'promediosPorCurso',
            'promedio',
            'promedioPorcentaje'
        ));
    }
    public function show()
    {
        $user = Auth::user();
        $aula = $user->aulas()->first();

        if (!$aula) {
            return view('panel.calificaciones.show', [
                'estudiantes' => [],
                'todosLosEstudiantes' => [],
                'calificacionesPorEstudiante' => [],
                'aula' => null,
                'cursosContados' => [],
                'cursosAula' => []
            ]);
        }

        $cursosAula = \App\Models\Curso::whereIn(
            'id',
            \App\Models\AulaCurso::where('aula_id', $aula->id)->pluck('curso_id')
        )->get();

        $todosLosEstudiantes = $aula->users()
            ->whereHas('roles', fn($q) => $q->where('id', 3))
            ->with(['persona', 'avatar'])
            ->get();

        $estudiantesQuery = $aula->users()
            ->whereHas('roles', fn($q) => $q->where('id', 3))
            ->with(['persona', 'avatar']);



        if (request()->filled('estudiante')) {
            $nombreCompleto = strtolower(request('estudiante'));
            $estudiantesQuery->whereHas('persona', function ($q) use ($nombreCompleto) {
                $q->whereRaw("LOWER(CONCAT(nombre, ' ', apellido)) LIKE ?", ["%{$nombreCompleto}%"]);
            });
        }

        $estudiantesFiltrados = $estudiantesQuery->get();

        $calificacionesPorEstudiante = [];
        $cursosContados = [];

        foreach ($estudiantesFiltrados as $estudiante) {
            $aulas = $estudiante->aulas()->pluck('aulas.id');
            $aulaCursoIds = \App\Models\AulaCurso::whereIn('aula_id', $aulas)->pluck('id');
            $sesionIds = \App\Models\Sesion::whereIn('aula_curso_id', $aulaCursoIds)->pluck('id');
            $evaluaciones = \App\Models\Evaluacion::whereIn('sesion_id', $sesionIds)->get();

            $calificaciones = [];


            foreach ($evaluaciones as $evaluacion) {
                $intentos = $evaluacion->intentos()
                    ->where('user_id', $estudiante->id)
                    ->where('estado', 'finalizado')
                    ->with('calificacion')
                    ->get();

                $mejorIntento = $intentos->sortByDesc(fn($i) => $i->calificacion->puntaje_total ?? 0)->first();

                if ($mejorIntento && $mejorIntento->calificacion) {
                    $calificaciones[] = [
                        'curso' => $evaluacion->sesion->aulaCurso->curso->curso ?? '',
                        'evaluacion' => $evaluacion->titulo,
                        'puntaje_total' => $mejorIntento->calificacion->puntaje_total,
                        'puntaje_maximo' => $mejorIntento->calificacion->puntaje_maximo,
                        'porcentaje' => $mejorIntento->calificacion->porcentaje,
                        'estado' => $mejorIntento->calificacion->estado,
                        'fecha_fin' => $mejorIntento->fecha_fin,
                        'intento_id' => $mejorIntento->id,
                        'intentos' => $intentos->count(),
                        'revision_vista' => $mejorIntento->revision_vista ?? false,
                    ];
                }
            }


            // Filtros adicionales
            if (request()->filled('curso')) {
                $cursoFiltro = request('curso');
                $calificaciones = array_filter($calificaciones, fn($c) => $c['curso'] === $cursoFiltro);
            }

            if (request()->filled('estado')) {
                $estadoFiltro = strtolower(request('estado'));
                $calificaciones = array_filter($calificaciones, fn($c) => strtolower($c['estado']) === $estadoFiltro);
            }

            if (request()->filled('fecha')) {
                $fecha = request('fecha');
                $calificaciones = array_filter($calificaciones, fn($c) => isset($c['fecha_fin']) && Carbon::parse($c['fecha_fin'])->format('Y-m-d') === $fecha);
            }

            if (request()->filled('fecha_inicio') && request()->filled('fecha_fin')) {
                $fechaInicio = request('fecha_inicio');
                $fechaFin = request('fecha_fin');
                $calificaciones = array_filter($calificaciones, fn($c) => isset($c['fecha_fin']) &&
                    Carbon::parse($c['fecha_fin'])->format('Y-m-d') >= $fechaInicio &&
                    Carbon::parse($c['fecha_fin'])->format('Y-m-d') <= $fechaFin);
            }

            // Ordenar por fecha (más reciente primero)
            usort($calificaciones, function ($a, $b) {
                return strtotime($b['fecha_fin']) <=> strtotime($a['fecha_fin']);
            });

            if (request()->filled('buscar')) {
                $buscar = strtolower(request('buscar'));

                $calificaciones = array_filter($calificaciones, function ($c) use ($buscar) {
                    return str_contains(strtolower($c['evaluacion']), $buscar);
                });

                // Si no hay coincidencias, saltar al siguiente estudiante
                if (empty($calificaciones)) {
                    continue;
                }
            }

            $calificacionesPorEstudiante[$estudiante->id] = array_values($calificaciones);

            foreach ($calificaciones as $calificacion) {
                $cursoNombre = $calificacion['curso'];
                if (!isset($cursosContados[$cursoNombre])) {
                    $cursosContados[$cursoNombre] = 0;
                }
                $cursosContados[$cursoNombre]++;
            }
        }

        $page = request()->get('page', 1);
        $perPage = 10;
        $offset = ($page - 1) * $perPage;

        $estudiantesPaginados = new \Illuminate\Pagination\LengthAwarePaginator(
            $estudiantesFiltrados->slice($offset, $perPage)->values(),
            $estudiantesFiltrados->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );


        $mejoresEstudiantes = collect();

        foreach ($calificacionesPorEstudiante as $id => $calificaciones) {
            if (count($calificaciones) === 0) continue;

            $total = array_sum(array_column($calificaciones, 'puntaje_total'));
            $max = array_sum(array_column($calificaciones, 'puntaje_maximo'));

            if ($max > 0) {
                $promedio = round(($total / $max) * 100, 2); // porcentaje
                $estudiante = $todosLosEstudiantes->firstWhere('id', $id);

                if ($estudiante) {
                    $mejoresEstudiantes->push([
                        'estudiante' => $estudiante,
                        'promedio' => $promedio
                    ]);
                }
            }
        }

        // Solo los aprobados (opcional, si quieres filtrar así)
        $mejoresEstudiantes = $mejoresEstudiantes
            ->sortByDesc('promedio')
            ->take(3)
            ->values();

        return view('panel.calificaciones.show', [
            'estudiantes' => $estudiantesPaginados,
            'todosLosEstudiantes' => $todosLosEstudiantes,
            'calificacionesPorEstudiante' => $calificacionesPorEstudiante,
            'aula' => $aula,
            'cursosContados' => $cursosContados,
            'cursosAula' => $cursosAula,
            'mejoresEstudiantes' => $mejoresEstudiantes
        ]);
    }
}
