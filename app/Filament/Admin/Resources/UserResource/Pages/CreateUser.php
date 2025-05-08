<?php

namespace App\Filament\Admin\Resources\UserResource\Pages;

use App\Filament\Admin\Resources\UserResource;
use Spatie\Permission\Models\Role;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
    protected function afterCreate(): void
    {
        $roleId = $this->data['role_id'] ?? null;
        if ($roleId) {
            $role = Role::find($roleId);
            if ($role) {
                $this->record->syncRoles([$role->name]);
            }
        }
    }
}
