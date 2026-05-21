<?php

namespace App\Filament\Resources\Roles;

use App\Filament\Resources\Roles\Pages\ListRoles;
use App\Filament\Resources\Roles\Pages\EditRole;
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

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShieldCheck;

    protected static ?string $tenantOwnershipRelationshipName = 'school';

    protected static string | \UnitEnum | null $navigationGroup = null;

    public static function getNavigationGroup(): ?string
    {
        return __('resources.catalogs');
    }

    public static function getNavigationLabel(): string
    {
        return __('resources.roles');
    }

    public static function getModelLabel(): string
    {
        return __('fields.role');
    }

    public static function getPluralModelLabel(): string
    {
        return __('resources.roles');
    }

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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRoles::route('/'),
            'edit' => EditRole::route('/{record}/edit'),
        ];
    }
}
