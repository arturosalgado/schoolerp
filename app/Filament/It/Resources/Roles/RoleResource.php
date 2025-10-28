<?php

namespace App\Filament\It\Resources\Roles;

use App\Filament\It\Resources\Roles\Pages\CreateRole;
use App\Filament\It\Resources\Roles\Pages\EditRole;
use App\Filament\It\Resources\Roles\Pages\ListRoles;
use App\Filament\It\Resources\Roles\RelationManagers\PermissionsRelationManager;
use App\Filament\It\Resources\Roles\RelationManagers\UsersRelationManager;
use App\Filament\It\Resources\Roles\Schemas\RoleForm;
use App\Filament\It\Resources\Roles\Tables\RolesTable;
use App\Models\Role;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return RoleForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RolesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            PermissionsRelationManager::class,
            UsersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRoles::route('/'),
            'create' => CreateRole::route('/create'),
            'edit' => EditRole::route('/{record}/edit'),
        ];
    }
}
