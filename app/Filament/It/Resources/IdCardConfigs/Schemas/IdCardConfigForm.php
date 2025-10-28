<?php

namespace App\Filament\It\Resources\IdCardConfigs\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class IdCardConfigForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([


                Section::make('Nombre')
                    ->schema([
                        Grid::make(4)
                            ->schema([
//
                                TextInput::make('name')
                                    ->label('Nombre')
                                    ->placeholder('Ej. Credencial Licenciatura')
                                    //->numeric()
                                   // ->default(50)
                                   // ->suffix('px')
                                    ->required(),

                                // TextInput::make('photo_height')
                                //     ->label('Alto de Foto')
                                //     ->numeric()
                                //     ->default(200)
                                //     ->suffix('px')
                                //     ->required(),
                            ]),
                    ])->columnSpanFull(),
                Section::make('Plantillas de Credencial')
                    ->description('Sube las plantillas del frente y reverso de la credencial')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                FileUpload::make('front_path')
                                    ->label('Plantilla Frontal')
                                    ->image()
                                    ->disk('s3')
                                    ->directory(fn () => tenant()?->name.'/credentials/front')
                                    ->visibility('private')
                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                    ->maxSize(5120) // 5MB
                                    ->imageResizeMode('contain')
                                    ->imageResizeTargetWidth(800)
                                    ->imageResizeTargetHeight(600)
                                    ->required()
                                    ->columnSpan(1),

                                FileUpload::make('back_path')
                                    ->label('Plantilla Trasera')
                                    ->image()
                                    ->disk('s3')
                                    ->directory(fn () => tenant()?->name.'/credentials/back')
                                    ->visibility('private')
                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                    ->maxSize(5120) // 5MB
                                    ->imageResizeMode('contain')
                                    ->imageResizeTargetWidth(800)
                                    ->imageResizeTargetHeight(600)
                                    ->columnSpan(1),
                            ]),
                    ])->columnSpanFull(),

                Section::make('Configuración de Posición de Foto')
                    ->description('Configura dónde se colocará la foto del estudiante en la plantilla frontal')
                    ->schema([
                        Grid::make(4)
                            ->schema([
//                                TextInput::make('photo_x')
//                                    ->label('Posición X de Foto')
//                                    ->numeric()
//                                    ->default(0)
//                                    ->suffix('px')
//                                    ->required(),

//                                TextInput::make('photo_y')
//                                    ->label('Posición Y de Foto')
//                                    ->numeric()
//                                    ->default(0)
//                                    ->suffix('px')
//                                    ->required(),

                                TextInput::make('photo_width')
                                    ->label('Ancho de Foto')
                                    ->numeric()
                                    ->default(50)
                                    ->suffix('px')
                                    ->required(),

                                // TextInput::make('photo_height')
                                //     ->label('Alto de Foto')
                                //     ->numeric()
                                //     ->default(200)
                                //     ->suffix('px')
                                //     ->required(),
                            ]),
                    ])->columnSpanFull(),

                Section::make('Configuración de Texto')
                    ->description('Configura el color, tamaño y fuente del texto en la credencial')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                ColorPicker::make('color')
                                    ->label('Color de Texto')
                                    ->default('#000000')
                                    ->required()
                                    ->columnSpan(1),

                                TextInput::make('size')
                                    ->label('Tamaño de Texto')
                                    ->numeric()
                                    ->default(12)
                                    ->suffix('px')
                                    ->minValue(8)
                                    ->maxValue(72)
                                    ->required()
                                    ->columnSpan(1),

                                Select::make('font')
                                    ->label('Fuente de Texto')
                                    ->options([
                                        'Arial' => 'Arial',
                                        'Helvetica' => 'Helvetica',
                                        'Times New Roman' => 'Times New Roman',
                                        'Georgia' => 'Georgia',
                                        'Courier New' => 'Courier New',
                                        'Verdana' => 'Verdana',
                                        'Trebuchet MS' => 'Trebuchet MS',
                                        'Impact' => 'Impact',
                                        'Comic Sans MS' => 'Comic Sans MS',
                                        'Tahoma' => 'Tahoma',
                                        'Palatino' => 'Palatino',
                                        'Garamond' => 'Garamond',
                                    ])
                                    ->default('Arial')
                                    ->required()
                                    ->searchable()
                                    ->columnSpan(1),
                            ]),
                    ])->columnSpanFull(),

                Section::make('Opciones de Visualización')
                    ->description('Controla qué información se muestra en la credencial')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                Toggle::make('showEnrollment')
                                    ->label('Mostrar Matrícula')
                                    ->default(true)
                                    ->inline(false)
                                    ->columnSpan(1),

                                Toggle::make('showProgram')
                                    ->label('Mostrar Programa/Carrera')
                                    ->default(true)
                                    ->inline(false)
                                    ->columnSpan(1),

                                Toggle::make('active')
                                    ->label('Activa')
                                    ->default(true)
                                    ->inline(false)
                                    ->columnSpan(1),


                            ]),
                    ])->columnSpanFull(),
            ]);

    }
}
