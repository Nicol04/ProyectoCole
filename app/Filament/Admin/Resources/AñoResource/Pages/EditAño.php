<?php

namespace App\Filament\Admin\Resources\AñoResource\Pages;

use App\Filament\Admin\Resources\AñoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAño extends EditRecord
{
    protected static string $resource = AñoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
