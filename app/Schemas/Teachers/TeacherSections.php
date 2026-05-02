<?php

namespace App\Schemas\Teachers;

use App\Services\SchoolFileUploadService;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

class TeacherSections
{
    public static function getPersonalData($panel = null): Section
    {
        return Section::make('Datos Personales')
            ->schema([
                TextInput::make('last_name')
                    ->required()
                    ->label('Apellido Paterno')
                    ->rules(['regex:/^[\pL\s\'\-]+$/u'])
                    ->maxLength(255)
                    ->columnSpan(1),
                TextInput::make('second_last_name')
                    ->label('Apellido Materno')
                    ->rules(['regex:/^[\pL\s\'\-]+$/u'])
                    ->maxLength(255)
                    ->columnSpan(1),
                TextInput::make('name')
                    ->label('Nombre(s)')
                    ->required()
                    ->rules(['regex:/^[\pL\s\'\-]+$/u'])
                    ->maxLength(255)
                    ->columnSpan(1),
            ])
            ->columns([
                'xl' => 3,
                '2xl' => 3,
            ]);
    }

    public static function getPhoto($panel = null): Section
    {
        return Section::make()
            ->collapsible()
            ->heading(__('fields.photo'))
            ->schema([
                FileUpload::make('picture')
                    ->disk('public')
                    ->directory(SchoolFileUploadService::getTeacherPhotoDirectory())
                    ->visibility('public')
                    ->image()
                    ->hiddenLabel()
                    ->imageEditor()
                    ->imageResizeMode('cover')
                    ->imageCropAspectRatio('1:1.2')
                    ->imageResizeTargetWidth('400')
                    ->imageResizeTargetHeight('460')
                    ->maxSize(2048)
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp']),
            ]);
    }

    public static function getContactData($panel = null): Section
    {
        return Section::make('Datos de Contacto')
            ->schema([
                TextInput::make('email')
                    ->required()
                    ->email()
                    ->label('Correo Electrónico')
                    ->maxLength(255)
                    ->columnSpan(1)
                    ->unique(
                        table: 'teachers',
                        column: 'email',
                        ignorable: fn ($record) => $record,
                    ),
                TextInput::make('mobile')
                    ->required()
                    ->label('Celular')
                    ->rules(['nullable', 'regex:/^[\d\s\(\)\+\-\.ext]+$/i'])
                    ->maxLength(25)
                    ->columnSpan(1),
            ])
            ->columns([
                'xl' => 2,
                '2xl' => 2,
            ]);
    }
}
