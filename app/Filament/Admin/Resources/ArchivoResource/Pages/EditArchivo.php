<?php

namespace App\Filament\Admin\Resources\ArchivoResource\Pages;

use App\Filament\Admin\Resources\ArchivoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditArchivo extends EditRecord
{
    protected static string $resource = ArchivoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
