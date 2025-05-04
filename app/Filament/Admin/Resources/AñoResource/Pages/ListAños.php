<?php

namespace App\Filament\Admin\Resources\AñoResource\Pages;

use App\Filament\Admin\Resources\AñoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAños extends ListRecords
{
    protected static string $resource = AñoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
