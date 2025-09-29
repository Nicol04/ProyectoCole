<?php

namespace App\Filament\Admin\Resources\SesionDetalleResource\Pages;

use App\Filament\Admin\Resources\SesionDetalleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSesionDetalles extends ListRecords
{
    protected static string $resource = SesionDetalleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
