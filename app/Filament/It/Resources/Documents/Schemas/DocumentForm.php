<?php

namespace App\Filament\It\Resources\Documents\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DocumentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información del Documento')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nombre')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Toggle::make('active')
                            ->label('Activo')
                            ->default(true)
                            ->inline(false),

                        Toggle::make('required')
                            ->label('Requerido')
                            ->default(false)
                            ->inline(false)
                            ->helperText('Indica si este documento es obligatorio para los estudiantes'),
                    ])
                    ->columns(2),
            ]);
    }
}
