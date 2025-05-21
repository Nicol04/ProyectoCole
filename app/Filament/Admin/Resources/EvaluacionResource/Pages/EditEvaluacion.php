<?php

namespace App\Filament\Admin\Resources\EvaluacionResource\Pages;

use App\Filament\Admin\Resources\EvaluacionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEvaluacion extends EditRecord
{
    protected static string $resource = EvaluacionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
