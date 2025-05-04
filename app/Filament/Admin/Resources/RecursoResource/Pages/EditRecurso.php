<?php

namespace App\Filament\Admin\Resources\RecursoResource\Pages;

use App\Filament\Admin\Resources\RecursoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRecurso extends EditRecord
{
    protected static string $resource = RecursoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
