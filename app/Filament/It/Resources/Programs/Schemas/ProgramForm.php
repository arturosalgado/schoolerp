<?php

namespace App\Filament\It\Resources\Programs\Schemas;

use App\Models\ProgramLevel;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProgramForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información del Programa')
                    ->description('Ingrese la información básica del programa')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nombre del Program')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpan(1),

                                Select::make('program_level_id')
                                    ->label('Nivel del Programa')
                                    ->options(fn () => ProgramLevel::where('school_id', tenant()?->id)
                                        ->where('active', true)
                                        ->pluck('name', 'id'))
                                    ->searchable()
                                    ->preload()
                                    ->nullable()
                                    ->columnSpan(1),

                                Toggle::make('active')
                                    ->label('Activo')
                                    ->default(true)
                                    ->inline(false)
                                    ->columnSpan(1),
                            ]),
                    ])->columnSpanFull(),

                Section::make('Documentos')
                    ->description('Cargue los documentos relacionados con el programa')
                    ->schema([
                        FileUpload::make('plan_de_estudios_pdf')
                            ->label('Plan de Estudios (PDF)')
                            ->acceptedFileTypes(['application/pdf'])
                            ->disk('s3')
                            ->directory(fn () => tenant()?->name.'/programs/plans')
                            ->visibility('private')
                            ->maxSize(10240) // 10MB
                            ->nullable()
                            ->columnSpanFull(),
                    ])->columnSpanFull(),

                Section::make('Campos Adicionales')
                    ->description('Campos extra personalizables')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('extra_field_1')
                                    ->label('Campo Extra 1')
                                    ->maxLength(255)
                                    ->nullable()
                                    ->columnSpan(1),

                                TextInput::make('extra_field_2')
                                    ->label('Campo Extra 2')
                                    ->maxLength(255)
                                    ->nullable()
                                    ->columnSpan(1),
                            ]),
                    ])->columnSpanFull()
                    ->collapsible()
                    ->collapsed(),
            ]);
    }
}
