<?php

namespace App\Filament\Admin\Resources\RubricaDetalleResource\Pages;

use App\Filament\Admin\Resources\RubricaDetalleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRubricaDetalle extends EditRecord
{
    protected static string $resource = RubricaDetalleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
