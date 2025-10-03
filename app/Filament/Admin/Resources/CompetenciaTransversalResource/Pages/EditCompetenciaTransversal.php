<?php

namespace App\Filament\Admin\Resources\CompetenciaTransversalResource\Pages;

use App\Filament\Admin\Resources\CompetenciaTransversalResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCompetenciaTransversal extends EditRecord
{
    protected static string $resource = CompetenciaTransversalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
