<?php

namespace App\Filament\Admin\Resources\RubricaDetalleResource\Pages;

use App\Filament\Admin\Resources\RubricaDetalleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRubricaDetalles extends ListRecords
{
    protected static string $resource = RubricaDetalleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
