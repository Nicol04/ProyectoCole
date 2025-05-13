<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Illuminate\Support\Facades\Storage;
use App\Models\Persona;

class ExportUser extends BaseExport implements FromCollection, WithHeadings, WithTitle
{
    public function __construct()
    {
        parent::__construct(
            titulo: 'Colegio Ann Goulden',
            subtitulo: 'Tabla de usuarios',
            ultimaColumna: 'K', // Ajusta según el número de columnas
            colorSubtitulo: '9ca3ac' // Azul claro
        );
        $this->columnasCentradas = ['B', 'F', 'G', 'K'];
    }
    public function collection()
    {
        return Persona::with(['user.roles', 'user.aulas']) // ✅ Relación correcta
            ->get()
            ->map(function ($persona) {
                return [
                    'nombre' => $persona->nombre,
                    'apellido' => $persona->apellido,
                    'dni' => $persona->dni,
                    'genero' => $persona->genero,
                    'usuario' => $persona->user->name ?? 'N/A',
                    'email' => $persona->user->email ?? 'N/A',
                    'estado' => $persona->user->estado ?? 'N/A',
                    'grado' => $persona->user->aulas->first()?->grado ?? 'N/A',
                    'seccion' => $persona->user->aulas->first()?->seccion ?? 'N/A',
                    'rol' => $persona->user?->getRoleNames()->first() ?? 'Sin rol',
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
            'Email',
            'Estado',
            'Grado',
            'Sección',
            'Rol',
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
