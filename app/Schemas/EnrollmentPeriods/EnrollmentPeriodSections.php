<?php

namespace App\Schemas\EnrollmentPeriods;

use App\Models\Cycle;
use App\Models\Program;
use App\Models\Term;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EnrollmentPeriodSections
{
    public static function getForm(Schema $schema): Schema
    {
        return $schema
            ->components([
                static::getBasicInfo(),
                static::getPrograms(),
                static::getTerms(),
            ]);
    }

    public static function getBasicInfo(): Section
    {
        return Section::make(__('fields.enrollment_details'))
            ->description(__('fields.enrollment_period_form_description'))
            ->schema([
                Grid::make(2)
                    ->schema([
                        Select::make('cycle_id')
                            ->label(__('fields.cycle'))
                            ->options(fn () => Cycle::where('school_id', school_id())
                                ->orderBy('start_date', 'desc')
                                ->get()
                                ->mapWithKeys(fn ($c) => [$c->id => $c->start_date->format('Y') . ' - ' . $c->end_date->format('Y')]))
                            ->required()
                            ->searchable()
                            ->preload()
                            ->reactive()
                            ->afterStateUpdated(fn (callable $set) => $set('terms', []))
                            ->columnSpan(1),

                        Toggle::make('is_active')
                            ->label(__('fields.is_active'))
                            ->default(false)
                            ->inline(false)
                            ->columnSpan(1),

                        DatePicker::make('opens_at')
                            ->label(__('fields.opens_at'))
                            ->required()
                            ->columnSpan(1),

                        DatePicker::make('closes_at')
                            ->label(__('fields.closes_at'))
                            ->required()
                            ->afterOrEqual('opens_at')
                            ->columnSpan(1),
                    ]),
            ])->columnSpanFull();
    }

    public static function getPrograms(): Section
    {
        return Section::make(__('fields.programs'))
            ->description(__('fields.enrollment_programs_description'))
            ->schema([
                Select::make('programs')
                    ->label(__('fields.programs'))
                    ->multiple()
                    ->relationship('programs', 'name')
                    ->options(fn () => Program::where('school_id', school_id())
                        ->where('active', true)
                        ->pluck('name', 'id'))
                    ->preload()
                    ->columnSpanFull(),
            ])->columnSpanFull();
    }

    public static function getTerms(): Section
    {
        return Section::make(__('fields.terms'))
            ->description(__('fields.enrollment_terms_description'))
            ->schema([
                Select::make('terms')
                    ->label(__('fields.terms'))
                    ->multiple()
                    ->relationship('terms', 'name')
                    ->options(fn (callable $get) => Term::where('school_id', school_id())
                        ->when($get('cycle_id'), fn ($query, $cycleId) => $query->where('cycle_id', $cycleId))
                        ->pluck('name', 'id'))
                    ->preload()
                    ->columnSpanFull(),
            ])->columnSpanFull()
            ->collapsible();
    }
}
