<?php
namespace App\Services;

use App\Models\Año;
use App\Models\Semestre;
use App\Models\Semana;
use Carbon\Carbon;

class AñoEscolarService
{
    public function crearAñoConSemestresYSemanas(string $nombre, string $inicio)
    {
        $fechaInicio = Carbon::parse($inicio);
        $año = Año::create([
            'nombre' => $nombre,
            'fecha_inicio' => $fechaInicio,
            'fecha_fin' => $fechaInicio->copy()->addWeeks(43),
        ]);

        $semanasPorBimestre = [ // 4 bimestres = 9 lectivas + 2 de gestión cada uno
            ['lectivas' => 9, 'gestion' => 2],
            ['lectivas' => 9, 'gestion' => 2],
            ['lectivas' => 9, 'gestion' => 2],
            ['lectivas' => 9, 'gestion' => 2],
        ];

        foreach ($semanasPorBimestre as $index => $config) {
            $nombreSemestre = 'Bimestre ' . ($index + 1);
            $fechaInicioBimestre = $fechaInicio->copy();

            $semestre = $año->semestres()->create([
                'nombre' => $nombreSemestre,
                'fecha_inicio' => $fechaInicioBimestre,
                'fecha_fin' => $fechaInicioBimestre->copy()->addWeeks($config['lectivas'] + $config['gestion'] - 1),
            ]);

            for ($i = 1; $i <= $config['lectivas']; $i++) {
                $semestre->semanas()->create([
                    'nombre' => 'Semana ' . $i,
                    'tipo' => 'lectiva',
                    'fecha_inicio' => $fechaInicio->copy(),
                    'fecha_fin' => $fechaInicio->copy()->addDays(6),
                ]);
                $fechaInicio->addWeek();
            }

            // Crear semanas de gestión
            for ($i = 1; $i <= $config['gestion']; $i++) {
                $semestre->semanas()->create([
                    'nombre' => 'Semana Gestión ' . $i,
                    'tipo' => 'gestion',
                    'fecha_inicio' => $fechaInicio->copy(),
                    'fecha_fin' => $fechaInicio->copy()->addDays(6),
                ]);
                $fechaInicio->addWeek();
            }
        }

        return $año;
    }
}