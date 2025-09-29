<?php

namespace App\Filament\Admin\Resources\RubricaResource\Pages;

use App\Filament\Admin\Resources\RubricaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRubrica extends EditRecord
{
    protected static string $resource = RubricaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
