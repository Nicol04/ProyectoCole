<?php

namespace App\Http\Controllers;

use App\Models\User;
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
                // Estado según el porcentaje
                if ($promedioPorcentaje >= 70) {
                    $estado = 'Aprobado';
                } elseif ($promedioPorcentaje >= 50) {
                    $estado = 'Intermedio';
                } else {
                    $estado = 'Desaprobado';
                }
                $promediosPorCurso[$nombre] = [
                    'promedio_porcentaje' => $promedioPorcentaje,
                    'estado' => $estado,
                    'cantidad' => $porCurso[$nombre]['cantidad'],
                ];
            } else {
                $promediosPorCurso[$nombre] = [
                    'promedio_porcentaje' => 0,
                    'estado' => 'Sin datos',
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

        return view('panel.calificaciones.show');
    }
}
