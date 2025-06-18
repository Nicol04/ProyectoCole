<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class HistorialEstudiantesExport extends BaseExport implements FromCollection, WithHeadings, WithTitle
{
    public $evaluacionId;
    public function __construct($evaluacionId)
    {
        $this->evaluacionId = $evaluacionId;
        parent::__construct(
            titulo: 'Colegio Ann Goulden',
            subtitulo: 'Historial de estudiantes',
            ultimaColumna: 'J',
            colorSubtitulo: '9ca3ac'
        );
        $this->columnasCentradas = ['E', 'F', 'G', 'H', 'I'];
    }
    public function collection()
    {
        return User::role('Estudiante')->with([
            'persona',
            'intentos' => function($q) {
                $q->where('evaluacion_id', $this->evaluacionId)->with(['calificacion', 'evaluacion.sesion']);
            }
        ])->get()->map(function ($user) {
            $persona = $user->persona;
            $intentos = $user->intentos;
            $ultimoIntento = $intentos->last();
            $mejorIntento = $intentos->sortByDesc(function ($i) {
                return $i->calificacion->puntaje_total ?? 0;
            })->first();

            $estado = $ultimoIntento ? ucfirst($ultimoIntento->estado) : 'Sin intento';
            $puntaje = $mejorIntento && $mejorIntento->calificacion ? $mejorIntento->calificacion->puntaje_total : 0;
            $puntajeMax = $mejorIntento && $mejorIntento->calificacion ? $mejorIntento->calificacion->puntaje_maximo : 0;
            $porcentaje = $puntajeMax > 0 ? round(($puntaje / $puntajeMax) * 100) : 0;
            $estadoCalificacion = $mejorIntento && $mejorIntento->calificacion ? strtoupper($mejorIntento->calificacion->estado) : 'SIN ESTADO';
            $nombreSesion = $mejorIntento && $mejorIntento->evaluacion && $mejorIntento->evaluacion->sesion ? $mejorIntento->evaluacion->sesion->titulo : '-';

            return [
                'nombre' => $persona->nombre ?? '-',
                'apellido' => $persona->apellido ?? '-',
                'estado' => $estado,
                'puntaje' => $puntaje . '/' . $puntajeMax,
                'intentos' => $intentos->count(),
                'porcentaje' => $porcentaje . '%',
                'estado_calificacion' => $estadoCalificacion,
                'nombre_sesion' => $nombreSesion,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nombre',
            'Apellido',
            'Estado',
            'Puntaje',
            'Intentos realizados',
            'Porcentaje',
            'Estado calificación',
            'Nombre de sesión',
        ];
    }

    public function title(): string
    {
        return 'Historial estudiantes';
    }
}
