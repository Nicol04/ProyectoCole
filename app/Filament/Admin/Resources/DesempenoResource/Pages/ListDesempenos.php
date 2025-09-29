<?php

namespace App\Filament\Admin\Resources\DesempenoResource\Pages;

use App\Filament\Admin\Resources\DesempenoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDesempenos extends ListRecords
{
    protected static string $resource = DesempenoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
