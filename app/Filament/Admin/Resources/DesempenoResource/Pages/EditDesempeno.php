<?php

namespace App\Filament\Admin\Resources\DesempenoResource\Pages;

use App\Filament\Admin\Resources\DesempenoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDesempeno extends EditRecord
{
    protected static string $resource = DesempenoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
