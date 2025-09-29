<?php

namespace App\Filament\Admin\Resources\CriterioEvaluacionResource\Pages;

use App\Filament\Admin\Resources\CriterioEvaluacionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCriterioEvaluacion extends EditRecord
{
    protected static string $resource = CriterioEvaluacionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
