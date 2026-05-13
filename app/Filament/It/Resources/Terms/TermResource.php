<?php

namespace App\Filament\It\Resources\Terms;

use App\Filament\It\Resources\Terms\Pages\CreateTerm;
use App\Filament\It\Resources\Terms\Pages\EditTerm;
use App\Filament\It\Resources\Terms\Pages\ListTerms;
use App\Schemas\Terms\TermSections;
use App\Tables\Terms\TermTable;
use App\Models\Term;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TermResource extends Resource
{
    protected static ?string $model = Term::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClock;

    protected static ?string $tenantOwnershipRelationshipName = 'school';

    protected static string | \UnitEnum | null $navigationGroup = null;

    public static function getNavigationGroup(): ?string
    {
        return __('resources.catalogs');
    }

    public static function getNavigationLabel(): string
    {
        return __('fields.terms');
    }

    public static function getModelLabel(): string
    {
        return __('fields.term');
    }

    public static function getPluralModelLabel(): string
    {
        return __('fields.terms');
    }

    public static function form(Schema $schema): Schema
    {
        return TermSections::getForm($schema);
    }

    public static function table(Table $table): Table
    {
        return TermTable::getTable($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTerms::route('/'),
            'create' => CreateTerm::route('/create'),
            'edit' => EditTerm::route('/{record}/edit'),
        ];
    }
}
