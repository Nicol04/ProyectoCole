<?php

namespace App\Filament\Admin\Resources\EnfoqueTransversalResource\Pages;

use App\Filament\Admin\Resources\EnfoqueTransversalResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEnfoqueTransversal extends EditRecord
{
    protected static string $resource = EnfoqueTransversalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
