<?php

namespace App\Filament\Admin\Resources\RecursoResource\Pages;

use App\Filament\Admin\Resources\RecursoResource;
use App\Models\Recurso;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class CreateRecurso extends CreateRecord
{
    protected static string $resource = RecursoResource::class;
    protected function handleRecordCreation(array $data): Recurso
    {
        if (isset($data['archivo'])) {
            $localPath = storage_path('app/public/' . $data['archivo']);
            if (!file_exists($localPath)) {
                throw new \Exception("El archivo no existe en la ruta: $localPath");
            }

            try {
                $upload = Cloudinary::uploadApi()->upload($localPath, [
                    'folder' => 'recursos_3d',
                ]);

                if (isset($upload['secure_url'], $upload['public_id'])) {
                    $data['url'] = $upload['secure_url'];
                    $data['public_id'] = $upload['public_id'];
                } else {
                    Log::error('Respuesta inesperada de Cloudinary:', ['response' => $upload]);
                    throw new \Exception('Falló la carga a Cloudinary. Respuesta incompleta.');
                }
            } catch (\Exception $e) {
                Log::error('Error al subir a Cloudinary: ' . $e->getMessage());
                throw new \Exception('Error al subir el archivo a Cloudinary.');
            }
        }

        unset($data['archivo']);
        return static::getModel()::create($data);
    }
}
