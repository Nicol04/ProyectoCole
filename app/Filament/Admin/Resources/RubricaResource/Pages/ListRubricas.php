<?php

namespace App\Filament\Admin\Resources\RubricaResource\Pages;

use App\Filament\Admin\Resources\RubricaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRubricas extends ListRecords
{
    protected static string $resource = RubricaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
