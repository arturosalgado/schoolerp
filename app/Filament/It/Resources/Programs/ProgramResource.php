<?php

namespace App\Filament\It\Resources\Programs;

use App\Filament\It\Resources\Programs\Pages\CreateProgram;
use App\Filament\It\Resources\Programs\Pages\EditProgram;
use App\Filament\It\Resources\Programs\Pages\ListPrograms;
use App\Filament\It\Resources\Programs\Schemas\ProgramForm;
use App\Filament\It\Resources\Programs\Tables\ProgramsTable;
use App\Models\Program;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ProgramResource extends Resource
{
    protected static ?string $model = Program::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAcademicCap;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationLabel = 'Programas';

    protected static ?string $modelLabel = 'Programa';

    protected static ?string $pluralModelLabel = 'Programas';

    public static function form(Schema $schema): Schema
    {
        return ProgramForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProgramsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPrograms::route('/'),
            'create' => CreateProgram::route('/create'),
            'edit' => EditProgram::route('/{record}/edit'),
        ];
    }
}
