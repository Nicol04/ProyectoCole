<?php

namespace App\Filament\Admin\Resources\UserResource\Pages;

use App\Filament\Admin\Resources\UserResource;
use Spatie\Permission\Models\Role;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;
    protected function getHeaderActions(): array
    {
        return [];
    }
    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (empty($data['password'])) {
            unset($data['password']);
        }
        return $data;
    }

    protected function afterSave(): void
    {
        $roleId = $this->data['role_id'] ?? null;
        if ($roleId) {
            $role = Role::find($roleId);
            if ($role) {
                $this->record->syncRoles([$role->name]);
            }
        }
    }
    public static function canDelete($record): bool
    {
        return false;
    }
}
