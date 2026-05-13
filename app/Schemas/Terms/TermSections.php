<?php

namespace App\Schemas\Terms;

use App\Models\Cycle;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TermSections
{
    public static function getForm(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('fields.term'))
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->label(__('fields.name'))
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder(__('fields.term_name_placeholder'))
                                    ->columnSpan(1),

                                Select::make('cycle_id')
                                    ->label(__('fields.cycle'))
                                    ->options(fn () => Cycle::where('school_id', school_id())
                                        ->orderBy('start_date', 'desc')
                                        ->get()
                                        ->mapWithKeys(fn ($c) => [$c->id => $c->start_date->format('Y') . ' - ' . $c->end_date->format('Y')]))
                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->columnSpan(1),

                                DatePicker::make('start_date')
                                    ->label(__('fields.start_date'))
                                    ->columnSpan(1),

                                DatePicker::make('end_date')
                                    ->label(__('fields.end_date'))
                                    ->afterOrEqual('start_date')
                                    ->columnSpan(1),

                                TextInput::make('order')
                                    ->label(__('fields.order'))
                                    ->numeric()
                                    ->default(0)
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
