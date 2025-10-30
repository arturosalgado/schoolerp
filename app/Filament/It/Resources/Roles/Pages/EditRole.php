<?php

namespace App\Filament\It\Resources\Roles\Pages;

use App\Filament\It\Resources\Roles\RoleResource;
use App\Models\Permission;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditRole extends EditRecord
{
    protected static string $resource = RoleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {

        $panelIds = $this->data['panels'];

        // Get the panel names from the selected panel IDs
        $panelNames = \App\Models\Panel::whereIn('id', $panelIds)->pluck('name')->toArray();

        // Get permissions only for the selected panels
        $permissions = Permission::whereIn('panel', $panelNames)->get();

        $permissionsWithPivot = [];
        foreach ($permissions as $permission) {
            $permissionsWithPivot[$permission->id] = ['active' => false];
        }

        // Attach only the selected panels' permissions to the newly created role with active = false
        $this->record->permissions()->sync($permissionsWithPivot);


        $this->redirect(static::getResource()::getUrl('edit', ['record' => $this->record->id]));
    }
}
