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
        // Get the panel names from the selected panel IDs
        $panelIds = $this->data['panels'];
        $panelNames = \App\Models\Panel::whereIn('id', $panelIds)->pluck('name')->toArray();

        // Get all permissions for the selected panels
        $permissionsForPanels = Permission::whereIn('panel', $panelNames)->get();

        // Get current permissions with their active status
        $currentPermissions = $this->record->permissions()
            ->get()
            ->keyBy('id')
            ->map(fn($permission) => $permission->pivot->active);

        // Build the sync array
        $permissionsToSync = [];
        foreach ($permissionsForPanels as $permission) {
            // If permission already exists, preserve its active status
            if ($currentPermissions->has($permission->id)) {
                $permissionsToSync[$permission->id] = ['active' => $currentPermissions->get($permission->id)];
            } else {
                // New permission, set as inactive by default
                $permissionsToSync[$permission->id] = ['active' => false];
            }
        }

        $s = 'electrónico';

        // Sync permissions - this will add new ones and remove ones not in the array
        $this->record->permissions()->sync($permissionsToSync);

        // Redirect to refresh the page
        $this->redirect(static::getResource()::getUrl('edit', ['record' => $this->record->id]));
    }
}
