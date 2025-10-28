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

        $panelIds = $this->data['panels'];

        // Get the panel names from the selected panel IDs
        $panelNames = \App\Models\Panel::whereIn('id', $panelIds)->pluck('name')->toArray();

        // Get permissions only for the selected panels
        $permissions = Permission::whereIn('panel', $panelNames)->get();

        // Prepare permissions array with active field set to false by default
        $permissionsWithPivot = [];
        foreach ($permissions as $permission) {
            $permissionsWithPivot[$permission->id] = ['active' => false];
        }

        // Attach only the selected panels' permissions to the newly created role with active = false
        $this->record->permissions()->attach($permissionsWithPivot);
    }
}
