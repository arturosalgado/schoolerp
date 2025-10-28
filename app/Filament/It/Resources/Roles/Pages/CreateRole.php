<?php

namespace App\Filament\It\Resources\Roles\Pages;

use App\Filament\It\Resources\Roles\RoleResource;
use App\Models\Permission;
use Filament\Resources\Pages\CreateRecord;

class CreateRole extends CreateRecord
{
    protected static string $resource = RoleResource::class;

    protected function afterCreate(): void
    {
        // Get all available permissions
        $allPermissions = Permission::all();

        // Prepare permissions array with active field set to false by default
        $permissionsWithPivot = [];
        foreach ($allPermissions as $permission) {
            $permissionsWithPivot[$permission->id] = ['active' => false];
        }

        // Attach all permissions to the newly created role with active = false
        $this->record->permissions()->attach($permissionsWithPivot);
    }
}
