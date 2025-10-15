<?php

namespace App\Filament\Admin\Resources\UnidadResource\Pages;

use App\Filament\Admin\Resources\UnidadResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUnidad extends EditRecord
{
    protected static string $resource = UnidadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    /**
     * 🔹 Antes de cargar el formulario, rellenamos los campos
     * con los valores que están en la tabla unidad_detalles.
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $detalle = $this->record->detalles()->first();

        if ($detalle) {
            $data['contenido'] = $detalle->contenido ?? [];
            $data['enfoques'] = $detalle->enfoques ?? [];
            $data['materiales_basicos'] = $detalle->materiales_basicos ?? '';
            $data['recursos'] = $detalle->recursos ?? '';
        }

        return $data;
    }

    /**
     * 🔹 Después de guardar los cambios, actualizamos o creamos el detalle.
     */
    protected function afterSave(): void
    {
        $unidad = $this->record;

        $unidad->detalles()->updateOrCreate(
            ['unidad_id' => $unidad->id],
            [
                'contenido' => $this->data['contenido'] ?? [],
                'enfoques' => $this->data['enfoques'] ?? [],
                'materiales_basicos' => $this->data['materiales_basicos'] ?? '',
                'recursos' => $this->data['recursos'] ?? '',
            ]
        );
    }
}
