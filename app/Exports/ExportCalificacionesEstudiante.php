<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportCalificacionesEstudiante extends BaseExport implements FromArray, WithHeadings
{
    protected $calificaciones;

    public function __construct($calificaciones, $titulo, $subtitulo, $ultimaColumna = 'I')
    {
        parent::__construct($titulo, $subtitulo, $ultimaColumna, 'C6EFCE');
        $this->calificaciones = $calificaciones;
        $this->columnasCentradas = ['C', 'D', 'E', 'F', 'G'];
    }

    public function array(): array
    {
        return array_map(function ($c) {
            return [
                $c['curso'],
                $c['evaluacion'],
                $c['puntaje_total'],
                $c['puntaje_maximo'],
                ($c['puntaje_maximo'] > 0 ? round(($c['puntaje_total'] / $c['puntaje_maximo']) * 100) : 0) . '%',
                $c['fecha_fin'] ? \Carbon\Carbon::parse($c['fecha_fin'])->format('d/m/Y H:i') : '-',
                ucfirst(strtolower($c['estado'])),
                $c['intentos'] ?? 0,
            ];
        }, $this->calificaciones);
    }

    public function headings(): array
    {
        return [
            'Curso',
            'Evaluación',
            'Puntaje obtenido',
            'Puntaje máximo',
            'Porcentaje',
            'Fecha',
            'Estado',
            'Intentos',
        ];
    }
}