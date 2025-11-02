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
                    TextInput::make('name')->label('Nombre')
                    ->required(),
                    TextInput::make('email')->label('Correo Electrónico'),
                    TextInput::make('password')->password()->label('Contraseña')->hiddenOn('edit'),
                    Select::make('roles')
                        ->label('Roles')
                        ->multiple()
                        ->relationship('roles', 'label_es')
                        ->preload()
                        ->searchable(),
                ])->columnSpanFull()
                ->columns(4)



            ]);
    }
}
