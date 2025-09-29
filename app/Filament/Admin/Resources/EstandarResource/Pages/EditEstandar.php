<?php

namespace App\Filament\Admin\Resources\EstandarResource\Pages;

use App\Filament\Admin\Resources\EstandarResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEstandar extends EditRecord
{
    protected static string $resource = EstandarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
