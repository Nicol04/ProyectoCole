<?php

namespace App\Filament\Admin\Resources\EstandarResource\Pages;

use App\Filament\Admin\Resources\EstandarResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEstandars extends ListRecords
{
    protected static string $resource = EstandarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
