<?php

namespace App\Filament\Admin\Resources\ListaCotejoResource\Pages;

use App\Filament\Admin\Resources\ListaCotejoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListListaCotejos extends ListRecords
{
    protected static string $resource = ListaCotejoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
