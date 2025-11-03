<?php

namespace App\Filament\It\Resources\Activities\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ActivityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('school_id')
                    ->relationship('school', 'slug'),
                TextInput::make('level'),
                TextInput::make('log_name'),
                Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('subject_type'),
                TextInput::make('event'),
                TextInput::make('subject_id')
                    ->numeric(),
                TextInput::make('causer_type'),
                TextInput::make('causer_id')
                    ->numeric(),
                TextInput::make('properties'),
                TextInput::make('batch_uuid'),
            ]);
    }
}
