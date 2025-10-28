<?php

namespace App\Filament\It\Resources\Roles\RelationManagers;

use App\Models\Panel;
use App\Models\Permission;
use Filament\Actions\AttachAction;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\Action;
use Illuminate\Database\Eloquent\Collection;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Filters\SelectFilter;

class PermissionsRelationManager extends RelationManager
{
    protected static string $relationship = 'permissions';
    protected static ?string $title = 'Permisos';// cambia el titulo de la tabla, en la parte de abajo

    public function form(Schema $schema): Schema
    {
        $actions = [
            'viewAny'=>'ViewAny',
            'view'=>'View',
            'create'=>'Create',
            'update'=>'Update',
            'delete'=>'Delete',
            'restore'=>'Restore',
            'forceDelete'=>'ForceDelete',
            'replicate'=>'Replicate',

        ];

        $options = Panel::all()->pluck('name', 'name')->toArray();

        return $schema
            ->components([
                TextInput::make('resource')
                    ->required()
                    ->maxLength(255)


                ,
                Select::make('panel')->options($options)->preload()->required(),
                Select::make('action')->options($actions)->preload()->required(),
                TextInput::make('description')
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading('Permisos')
            ->persistSortInSession()
            ->recordTitleAttribute('description')
            ->columns([

                TextColumn::make('resource_es')->formatStateUsing(
                    function ($state) {
                        return ucfirst($state);
                    }
                )
                    ->label('Sección')
                    ->searchable()
                    ->sortable(),
//                TextColumn::make('name')
//                    ->label('Name')
//                    ->searchable()
//                    ->sortable(),

                TextColumn::make('action')
                    ->label('Accion')
                    ->searchable()
                    ->formatStateUsing(function($state){
                        return __('resources.'.$state,[],'es');
                    })
                    ->sortable(),

//                TextColumn::make('description')->label('Permiso')
//                    // ->label('Description')
//                    ->searchable()
//                    ->sortable(),
                TextColumn::make('panel')->formatStateUsing(fn ($state) =>
                    __('panels.' . $state, [], 'es') ?: ucfirst(str_replace('-', ' ', $state))
                )
                    ->label('Panel')
                    ->searchable()
                    ->sortable(),

//                TextColumn::make('action')->formatStateUsing(fn ($state) =>
//                    __('actions.' . $state, [], 'es') ?: ucfirst(str_replace('-', ' ', $state))
//                )
//                    ->label('Acción')
//                    ->searchable()
//                    ->sortable(),
                ToggleColumn::make('active')
                    ->label('Activo')
                    ->updateStateUsing(function ($record, $state) {
                        // Check if trying to deactivate a critical permission
                        if (!$state && !$this->ownerRecord->canDeactivatePermission($record->name)) {
                            // Prevent deactivation and show error
                            \Filament\Notifications\Notification::make()
                                ->title('No se puede desactivar')
                                ->body('Este permiso es crítico para el rol y no puede ser desactivado.')
                                ->danger()
                                ->send();

                            return true; // Keep it active
                        }
                        // If activating edit or create, also activate viewAny for the same resource/panel
                        if ($state && in_array($record->action, ['update', 'create'])) {
                            $viewAnyPermission = Permission::where('resource', $record->resource)
                                ->where('panel', $record->panel)
                                ->where('action', 'viewAny')
                                ->first();

                            if ($viewAnyPermission && $this->ownerRecord->permissions()->where('permissions.id', $viewAnyPermission->id)->exists()) {
                                $this->ownerRecord->permissions()->updateExistingPivot($viewAnyPermission->id, ['active' => true]);
                            }
                        }

                        // Update the pivot table's active field
                        $this->ownerRecord->permissions()->updateExistingPivot($record->id, ['active' => $state]);
                        return $state;
                    })
                    ->getStateUsing(function ($record) {
                        // Get the current active state from the pivot table
                        $pivot = $this->ownerRecord->permissions()->where('permissions.id', $record->id)->first()?->pivot;
                        return $pivot ? $pivot->active : false;
                    })
                    ->disabled(function ($record) {
                        // Disable toggle for critical permissions that are currently active
                        $pivot = $this->ownerRecord->permissions()->where('permissions.id', $record->id)->first()?->pivot;
                        $isActive = $pivot ? $pivot->active : false;

                    return $isActive && !$this->ownerRecord->canDeactivatePermission($record->name);
                    }),
            ])
            ->groups([
                Group::make('panel')
                    ->getTitleFromRecordUsing(fn ($record) => 'Panel: ' . (__('panels.' . $record->panel, [], 'es') ?: ucfirst(str_replace('-', ' ', $record->panel)))),
                Group::make('resource')
                    ->getTitleFromRecordUsing(fn ($record) => 'Sección: ' . (__('resources.' . $record->resource, [], 'es') ?: ucfirst(str_replace('-', ' ', $record->resource)))),
                Group::make('action')
                    ->getTitleFromRecordUsing(fn ($record) => 'Acción: ' . (__('actions.' . $record->action, [], 'es') ?: ucfirst(str_replace('-', ' ', $record->action)))),
            ])
            ->defaultGroup('panel')
            ->paginated(false)
            ->filters([
                SelectFilter::make('panel')
                    ->label('Panel')
                    ->options(Panel::all()->pluck('name', 'name')->mapWithKeys(function ($panelName) {
                        return [$panelName => __('panels.' . $panelName, [], 'es') ?: ucfirst(str_replace('-', ' ', $panelName))];
                    })->toArray())
                    ->searchable()
                    ->preload(),
            ])
            ->headerActions([
                //CreateAction::make()->label('Agregar Permiso'), Permissions are created by Super, only
                AttachAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                Action::make('duplicate')
                    ->label('Duplicate')
                    ->icon('heroicon-o-document-duplicate')
                    ->schema([
                        TextInput::make('resource')
                            ->required()
                            ->maxLength(255),
                        Select::make('panel')
                            ->options(Panel::all()->pluck('name', 'name')->toArray())
                            ->preload()
                            ->required(),
                        Select::make('action')
                            ->options([
                                'viewAny' => 'ViewAny',
                                'view' => 'View',
                                'create' => 'Create',
                                'update' => 'Update',
                                'delete' => 'Delete',
                                'restore' => 'Restore',
                                'forceDelete' => 'ForceDelete',
                                'replicate' => 'Replicate',
                            ])
                            ->preload()
                            ->required(),
                        TextInput::make('description')
                    ])
                    ->fillForm(fn ($record) => [
                        'resource' => $record->resource,
                        'panel' => $record->panel,
                        'action' => $record->action,
                    ])
                    ->action(function ($record, array $data) {
                        // Create new permission with the form data
                        $newPermission = Permission::create([
                            'resource' => $data['resource'],
                            'panel' => $data['panel'],
                            'action'=>$data['action'],
                         //   'name' => $data['panel'] . '.' . $data['resource'] . '.' . $data['action'],
                            'description' => 'Duplicated from: ' . $record->description,
                        ]);

                        // Attach the new permission to the current role with the same active status
                        $pivot = $this->ownerRecord->permissions()->where('permissions.id', $record->id)->first()?->pivot;
                        $activeStatus = $pivot ? $pivot->active : false;

                        $this->ownerRecord->permissions()->attach($newPermission->id, ['active' => $activeStatus]);
                    })
                    ->successNotificationTitle('Permission duplicated successfully'),
             //   DetachAction::make(),
               // DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DetachBulkAction::make()
                    ->action(function (Collection $records) {
                        foreach ($records as $permission) {
                            $this->ownerRecord->permissions()->detach($permission->id);

                        }
                    }),

                    BulkAction::make('enable_all')
                        ->label('Activar Todos')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(function (Collection $records) {
                            foreach ($records as $permission) {
                                $this->ownerRecord->permissions()->updateExistingPivot(
                                    $permission->id,
                                    ['active' => true]
                                );
                            }
                        })
                        ->deselectRecordsAfterCompletion()
                        ->successNotificationTitle('Permisos seleccionados activados'),
                    BulkAction::make('disable_all')
                        ->label('Desactivar Todos')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->action(function (Collection $records) {
                            $criticalPermissions = [];
                            $deactivatedCount = 0;

                            foreach ($records as $permission) {
                                if (!$this->ownerRecord->canDeactivatePermission($permission->name)) {
                                    $criticalPermissions[] = $permission->description;
                                } else {
                                    $this->ownerRecord->permissions()->updateExistingPivot(
                                        $permission->id,
                                        ['active' => false]
                                    );
                                    $deactivatedCount++;
                                }
                            }

                            // Show notifications
                            if ($deactivatedCount > 0) {
                                \Filament\Notifications\Notification::make()
                                    ->title("$deactivatedCount permisos desactivados")
                                    ->success()
                                    ->send();
                            }

                            if (!empty($criticalPermissions)) {
                                \Filament\Notifications\Notification::make()
                                    ->title('Algunos permisos no se pudieron desactivar')
                                    ->body('Los siguientes permisos son críticos: ' . implode(', ', $criticalPermissions))
                                    ->warning()
                                    ->send();
                            }
                        })
                        ->deselectRecordsAfterCompletion(),
                  //  DetachBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
