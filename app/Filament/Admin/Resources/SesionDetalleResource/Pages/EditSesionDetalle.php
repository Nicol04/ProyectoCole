<?php

namespace App\Filament\Admin\Resources\SesionDetalleResource\Pages;

use App\Filament\Admin\Resources\SesionDetalleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSesionDetalle extends EditRecord
{
    protected static string $resource = SesionDetalleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
