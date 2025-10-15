<?php

namespace App\Filament\Admin\Resources\UnidadResource\Pages;

use App\Filament\Admin\Resources\UnidadResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUnidad extends CreateRecord
{
    protected static string $resource = UnidadResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return $this->syncSeccionesDesdeDocentes($data);
    }

    private function syncSeccionesDesdeDocentes(array $data): array
    {
        if (empty($data['profesores_responsables'])) {
            $data['secciones'] = [];
            return $data;
        }

        $aulas = \App\Models\Aula::whereHas('users', function ($q) use ($data) {
            $q->whereIn('users.id', $data['profesores_responsables']);
        })
            ->select('seccion')
            ->distinct()
            ->pluck('seccion')
            ->toArray();

        $data['secciones'] = $aulas;

        return $data;
    }

    protected function afterCreate(): void
    {
        $unidad = $this->record;

        // Crear detalle de unidad si hay datos
        $unidad->detalles()->create([
            'contenido' => $this->data['contenido'] ?? [],
            'enfoques' => $this->data['enfoques'] ?? [],
            'materiales_basicos' => $this->data['materiales_basicos'] ?? '',
            'recursos' => $this->data['recursos'] ?? '',
        ]);
    }
}
