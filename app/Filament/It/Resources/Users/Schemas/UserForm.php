<?php

namespace App\Filament\It\Resources\Users\Schemas;

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
                    TextInput::make('nombres')
                        ->label('Nombre(s)')
                        ->required()
                        ->maxLength(80)
                        ->columnSpan(2),
                    TextInput::make('paterno')
                        ->label('Apellido Paterno')
                        ->required()
                        ->maxLength(80)
                        ->columnSpan(1),
                    TextInput::make('materno')
                        ->label('Apellido Materno')
                        ->maxLength(80)
                        ->columnSpan(1),
                    TextInput::make('email')
                        ->label('Correo Electrónico')
                        ->email()
                        ->required()
                        ->maxLength(255)
                        ->columnSpan(2),
                    TextInput::make('password')
                        ->password()
                        ->label('Contraseña')
                        ->hiddenOn('edit')
                        ->required(fn ($operation) => $operation === 'create')
                        ->minLength(8)
                        ->columnSpan(2),
                    Select::make('roles')
                        ->label('Roles')
                        ->multiple()
                        ->relationship('roles', 'label_es')
                        ->preload()
                        ->searchable()
                        ->columnSpan(4),
                ])->columnSpanFull()
                ->columns(4)
            ]);
    }
}
