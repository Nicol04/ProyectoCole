<?php

namespace App\Filament\Admin\Resources\UnidadResource\Pages;

use App\Filament\Admin\Resources\UnidadResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUnidads extends ListRecords
{
    protected static string $resource = UnidadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
