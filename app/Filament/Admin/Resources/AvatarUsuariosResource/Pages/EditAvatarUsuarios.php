<?php

namespace App\Filament\Admin\Resources\AvatarUsuariosResource\Pages;

use App\Filament\Admin\Resources\AvatarUsuariosResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAvatarUsuarios extends EditRecord
{
    protected static string $resource = AvatarUsuariosResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
