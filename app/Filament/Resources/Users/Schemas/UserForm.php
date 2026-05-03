<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()->schema([
                    TextInput::make('last_name')
                        ->label('Apellido Paterno')
                        ->required()
                        ->maxLength(30)
                        ->columnSpan(1),
                    TextInput::make('second_last_name')
                        ->label('Apellido Materno')
                        ->maxLength(30)
                        ->columnSpan(1),
                    TextInput::make('name')
                        ->label('Nombre(s)')
                        ->required()
                        ->maxLength(30)
                        ->columnSpan(2),
                    TextInput::make('email')
                        ->label('Correo Electrónico')
                        ->email()
                        ->required()
                        ->maxLength(255)
                        ->columnSpan(2),
                    Select::make('roles')
                        ->label('Roles')
                        ->multiple()
                        ->relationship('roles', 'label_es', function ($query) {
                            $query->where('roles.school_id', school_id())
                                  ->whereNotIn('roles.name', ['student', 'teacher','prospect']);
                        })
                        ->preload()
                        ->searchable()
                        ->required()
                        ->columnSpan(4),
                ])->columnSpan(2)
                ->columns(4),
                Section::make()
                    ->heading('Foto')
                    ->schema([
                        FileUpload::make('photo')
                            ->disk('public')
                            ->directory('user-photos')
                            ->visibility('public')
                            ->image()
                            ->hiddenLabel()
                            ->imageEditor()
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('1:1')
                            ->imageResizeTargetWidth('400')
                            ->imageResizeTargetHeight('400')
                            ->maxSize(2048)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp']),
                    ])->columnSpan(1),
            ])->columns(3);
    }
}
