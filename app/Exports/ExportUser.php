<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Illuminate\Support\Facades\Storage;
use App\Models\Persona;
use Illuminate\Contracts\Encryption\DecryptException;

class ExportUser extends BaseExport implements FromCollection, WithHeadings, WithTitle
{
    public function __construct()
    {
        parent::__construct(
            titulo: 'Colegio Ann Goulden',
            subtitulo: 'Tabla de usuarios',
            ultimaColumna: 'K',
            colorSubtitulo: '9ca3ac'
        );
        $this->columnasCentradas = ['B', 'F', 'G', 'K'];
    }
    public function collection()
{
    return Persona::with(['user.roles', 'user.aulas'])
        ->get()
        ->filter(function ($persona) {
            $user = $persona->user;

            // Si no tiene usuario, se incluye (puedes cambiar eso si quieres)
            if (!$user) return true;

            // Obtener IDs de roles del usuario
            $roleIds = $user->roles->pluck('id')->toArray();

            // Excluir si tiene rol 1 o 4
            return !in_array(1, $roleIds) && !in_array(4, $roleIds);
        })
        ->map(function ($persona) {
            $user = $persona->user;
            $passwordPlano = 'N/A';

            try {
                if (!empty($user?->password_plano)) {
                    $passwordPlano = decrypt($user->password_plano);
                }
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                $passwordPlano = 'Error';
            }

            return [
                'nombre' => $persona->nombre,
                'apellido' => $persona->apellido,
                'dni' => $persona->dni,
                'genero' => $persona->genero,
                'usuario' => $user?->name ?? 'N/A',
                'estado' => $user?->estado ?? 'N/A',
                'grado' => $user?->aulas->first()?->grado ?? 'N/A',
                'seccion' => $user?->aulas->first()?->seccion ?? 'N/A',
                'rol' => $user?->getRoleNames()->first() ?? 'Sin rol',
                'password_plano' => $passwordPlano,
            ];
        });
}


    /**
     * Define los encabezados.
     */
    public function headings(): array
    {
        return [
            'Nombres',
            'Apellidos',
            'DNI',
            'Género',
            'Usuario',
            'Estado',
            'Grado',
            'Sección',
            'Rol',
            'Contraseña',
        ];
    }
    /**
     * Define el título de la hoja.
     */
    public function title(): string
    {
        return 'Usuarios';
    }
}
