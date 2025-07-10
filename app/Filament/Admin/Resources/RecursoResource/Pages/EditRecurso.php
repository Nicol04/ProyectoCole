<?php

namespace App\Filament\Admin\Resources\RecursoResource\Pages;

use App\Filament\Admin\Resources\RecursoResource;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class EditRecurso extends EditRecord
{
    protected static string $resource = RecursoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (isset($data['archivo']) && is_string($data['archivo'])) {
            // Eliminar archivo viejo
            if ($this->record && $this->record->public_id) {
                try {
                    Cloudinary::uploadApi()->destroy($this->record->public_id);
                } catch (\Exception $e) {
                    Log::error("Error eliminando archivo en Cloudinary: " . $e->getMessage());
                }
            }

            $filePath = storage_path('app/public/' . $data['archivo']);

            if (!file_exists($filePath)) {
                Log::error("Archivo temporal no encontrado: " . $filePath);
                return $data;
            }

            // Subir archivo nuevo
            $resultado = Cloudinary::uploadApi()->upload($filePath, [
                'folder' => 'recursos_3d',
                'resource_type' => 'auto',
            ]);

            $data['url'] = $resultado['secure_url'];
            $data['public_id'] = $resultado['public_id'];

            // Opcional: borrar archivo local temporal
            unlink($filePath);
        } else {
            $data['url'] = $this->record->url;
            $data['public_id'] = $this->record->public_id;
        }

        return $data;
    }
}
