<?php

namespace App\Filament\It\Resources\Roles\Schemas;

use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class RoleForm
{
    public static function configure(Schema $schema): Schema
    {


        return $schema
            ->components([
                TextInput::make('name')->label('Nombre')
                    ->required(),



                Select::make('panels')
                    ->relationship('panels', 'displayNameEs')
                    ->label('Paneles')
                    ->multiple()
                    ->required()
                    ->preload(),
                Textarea::make('description')->label('Descripción')
                    ->columnSpanFull(),

                Toggle::make('is_active')->label('Activo')
                    ->default(true)
                    ->required(),
                Hidden::make('school_id')->default(school_id())
                ,
            ]);
    }
}
