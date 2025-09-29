<?php

namespace App\Filament\Admin\Resources\CapacidadResource\Pages;

use App\Filament\Admin\Resources\CapacidadResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCapacidads extends ListRecords
{
    protected static string $resource = CapacidadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
