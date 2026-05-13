<?php

namespace App\Filament\It\Resources\Cycles;

use App\Filament\It\Resources\Cycles\Pages\CreateCycle;
use App\Filament\It\Resources\Cycles\Pages\EditCycle;
use App\Filament\It\Resources\Cycles\Pages\ListCycles;
use App\Schemas\Cycles\CycleSections;
use App\Tables\Cycles\CycleTable;
use App\Models\Cycle;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CycleResource extends Resource
{
    protected static ?string $model = Cycle::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static ?string $tenantOwnershipRelationshipName = 'school';

    protected static string | \UnitEnum | null $navigationGroup = null;

    public static function getNavigationGroup(): ?string
    {
        return __('resources.catalogs');
    }

    public static function getNavigationLabel(): string
    {
        return __('resources.cycles');
    }

    public static function getModelLabel(): string
    {
        return __('fields.cycle');
    }

    public static function getPluralModelLabel(): string
    {
        return __('resources.cycles');
    }

    public static function form(Schema $schema): Schema
    {
        return CycleSections::getForm($schema);
    }

    public static function table(Table $table): Table
    {
        return CycleTable::getTable($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCycles::route('/'),
            'create' => CreateCycle::route('/create'),
            'edit' => EditCycle::route('/{record}/edit'),
        ];
    }
}
