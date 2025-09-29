<?php

namespace App\Filament\Admin\Resources\SesionMomentoResource\Pages;

use App\Filament\Admin\Resources\SesionMomentoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSesionMomentos extends ListRecords
{
    protected static string $resource = SesionMomentoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
