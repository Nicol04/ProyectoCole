<?php

namespace App\Filament\Admin\Resources\AulaResource\Pages;

use App\Filament\Admin\Resources\AulaResource;
use Filament\Resources\Pages\ViewRecord;

class ViewAula extends ViewRecord
{
    protected static string $resource = AulaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Deja vacío para no permitir editar o eliminar
        ];
    }
}
