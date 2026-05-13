<?php

namespace App\Schemas\Cycles;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CycleSections
{
    public static function getForm(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('fields.cycle'))
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                DatePicker::make('start_date')
                                    ->label(__('fields.start_date'))
                                    ->required()
                                    ->columnSpan(1),

                                DatePicker::make('end_date')
                                    ->label(__('fields.end_date'))
                                    ->required()
                                    ->afterOrEqual('start_date')
                                    ->columnSpan(1),

                                Toggle::make('is_active')
                                    ->label(__('fields.is_active'))
                                    ->default(true)
                                    ->inline(false)
                                    ->columnSpan(1),
                            ]),
                    ])->columnSpanFull(),
            ]);
    }
}
