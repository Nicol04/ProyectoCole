<?php

namespace App\Filament\Admin\Resources\CriterioEvaluacionResource\Pages;

use App\Filament\Admin\Resources\CriterioEvaluacionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCriterioEvaluacions extends ListRecords
{
    protected static string $resource = CriterioEvaluacionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
