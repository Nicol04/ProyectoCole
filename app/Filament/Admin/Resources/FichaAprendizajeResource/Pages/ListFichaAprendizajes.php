<?php

namespace App\Filament\Admin\Resources\FichaAprendizajeResource\Pages;

use App\Filament\Admin\Resources\FichaAprendizajeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFichaAprendizajes extends ListRecords
{
    protected static string $resource = FichaAprendizajeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
