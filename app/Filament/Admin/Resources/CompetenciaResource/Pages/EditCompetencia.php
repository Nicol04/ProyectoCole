<?php

namespace App\Filament\Admin\Resources\CompetenciaResource\Pages;

use App\Filament\Admin\Resources\CompetenciaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCompetencia extends EditRecord
{
    protected static string $resource = CompetenciaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
