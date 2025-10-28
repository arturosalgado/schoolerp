<?php

namespace App\Filament\InformationTechnology\Resources\Roles\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ReplicateAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RolesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultPaginationPageOption(50)
            ->columns([
                TextColumn::make('name')->label('Nombre')
                    ->searchable(),

                IconColumn::make('is_active')->label('Activo')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                ReplicateAction::make()->label('Duplicar')
                    ->beforeReplicaSaved(function ($replica, $record) {
                        // Generate a unique name to avoid constraint violations
                        $baseName = ($record->name ?? 'Role') . ' (Copy)';
                        $counter = 1;
                        $newName = $baseName;

                        // Check if name exists and increment counter if needed
                        while (\App\Models\Role::where('name', $newName)->exists()) {
                            $newName = $baseName . ' ' . $counter;
                            $counter++;
                        }

                        $replica->name = $newName;
                        $replica->school_id = $record->school_id ?? school_id();
                    })
                    ->after(function ($replica, $record) {
                        // Copy all permissions with their active status
                        if ($record && $replica) {
                            $permissionsToAttach = [];

                            // Get all permissions with their pivot data
                            $originalPermissions = $record->permissions()->withPivot('active')->get();

                            foreach ($originalPermissions as $permission) {
                                $permissionsToAttach[$permission->id] = [
                                    'active' => $permission->pivot->active ?? false,
                                    'created_at' => now(),
                                    'updated_at' => now(),
                                ];
                            }

                            // Attach all permissions at once
                            if (!empty($permissionsToAttach)) {
                                $replica->permissions()->attach($permissionsToAttach);
                            }
                        }
                    })
                    ->successNotificationTitle('Role replicated successfully'),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
