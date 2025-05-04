<?php

namespace App\Filament\Admin\Resources\AvatarUsuariosResource\Pages;

use App\Filament\Admin\Resources\AvatarUsuariosResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAvatarUsuarios extends ListRecords
{
    protected static string $resource = AvatarUsuariosResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
