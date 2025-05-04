<?php

namespace App\Filament\Admin\Resources\CursoResource\Pages;

use App\Filament\Admin\Resources\CursoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCurso extends EditRecord
{
    protected static string $resource = CursoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
