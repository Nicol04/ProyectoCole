<?php

namespace App\Filament\Admin\Resources\AulaResource\Pages;

use App\Filament\Admin\Resources\AulaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAulas extends ListRecords
{
    protected static string $resource = AulaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
