<?php

namespace App\Filament\Resources\Programs;

use App\Filament\Resources\Programs\Pages\CreateProgram;
use App\Filament\Resources\Programs\Pages\EditProgram;
use App\Filament\Resources\Programs\Pages\ListPrograms;
use App\Models\Program;
use BackedEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProgramResource extends Resource
{
    protected static ?string $model = Program::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAcademicCap;

    public static function getNavigationLabel(): string
    {
        return 'Programas';
    }

    public static function getModelLabel(): string
    {
        return 'Programa';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Programas';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')
                ->label('Nombre')
                ->required()
                ->maxLength(255),

            Select::make('program_level_id')
                ->label('Nivel')
                ->relationship('programLevel', 'name')
                ->required(),

            Toggle::make('active')
                ->label('Activo')
                ->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(
                Program::query()->where('school_id', school_id())
            )
            ->columns([
                TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('programLevel.name')
                    ->label('Nivel')
                    ->sortable(),

                IconColumn::make('active')
                    ->label('Activo')
                    ->boolean(),
            ])
            ->actions([
                EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListPrograms::route('/'),
            'create' => CreateProgram::route('/create'),
            'edit'   => EditProgram::route('/{record}/edit'),
        ];
    }
}
