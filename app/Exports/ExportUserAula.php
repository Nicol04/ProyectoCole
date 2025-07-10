<?php

namespace App\Exports;

use App\Models\Aula;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class ExportUserAula extends BaseExport implements FromCollection, WithHeadings, WithTitle
{
    protected $aulaId;

    public function __construct($aulaId)
    {
        $aula = Aula::find($aulaId);
        $grado = $aula?->grado ?? 'Sin grado';
        $seccion = $aula?->seccion ?? 'Sin sección';
        parent::__construct(
            titulo: 'Colegio Ann Goulden',
            subtitulo: 'Alumnos del aula - ' . $grado .  $seccion,
            ultimaColumna: 'H',
            colorSubtitulo: 'fdf59e'
        );

        $this->columnasCentradas = ['C', 'D', 'E', 'F','G', 'H'];
        $this->aulaId = $aulaId;
    }

    public function collection()
    {
        return Aula::find($this->aulaId)
            ->users()
            ->with(['persona', 'roles'])
            ->get()
            ->map(function ($user) {
                $persona = $user->persona;
                $passwordPlano = 'N/A';

                try {
                    if (!empty($user->password_plano)) {
                        $passwordPlano = decrypt($user->password_plano);
                    }
                } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                    $passwordPlano = 'Error';
                }

                return [
                    'nombre_completo' => ($persona?->nombre ?? 'N/A') . ' ' . ($persona?->apellido ?? 'N/A'),
                    'dni' => $persona?->dni ?? 'N/A',
                    'genero' => $persona?->genero ?? 'N/A',
                    'usuario' => $user->name ?? 'N/A',
                    'estado' => $user->estado ?? 'N/A',
                    'rol' => $user->getRoleNames()->first() ?? 'Sin rol',
                    'password_plano' => $passwordPlano,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Nombres y apellidos',
            'DNI',
            'Género',
            'Nombre de usuario',
            'Estado',
            'Rol',
            'Contraseña',
        ];
    }

    public function title(): string
    {
        $aula = Aula::find($this->aulaId);

        $grado = $aula?->grado ?? 'Sin grado';
        $seccion = $aula?->seccion ?? 'Sin sección';

        return "Usuarios - Grado: $grado, Sección: $seccion";
    }
}
