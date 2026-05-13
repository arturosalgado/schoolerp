<?php

namespace App\Tables\EnrollmentPeriods;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class EnrollmentPeriodTable
{
    public static function getTable(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('cycle.start_date')
                    ->label(__('fields.cycle'))
                    ->date('Y')
                    ->sortable(),

                TextColumn::make('opens_at')
                    ->label(__('fields.opens_at'))
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('closes_at')
                    ->label(__('fields.closes_at'))
                    ->date('d/m/Y')
                    ->sortable(),

                IconColumn::make('is_active')
                    ->label(__('fields.is_active'))
                    ->boolean()
                    ->trueIcon(Heroicon::OutlinedCheckCircle)
                    ->falseIcon(Heroicon::OutlinedXCircle)
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->sortable(),

                TextColumn::make('prospects_count')
                    ->label(__('resources.prospects'))
                    ->counts('prospects')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label(__('fields.created_at'))
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('is_active')
                    ->label(__('fields.is_active')),

                SelectFilter::make('cycle_id')
                    ->label(__('fields.cycle'))
                    ->relationship('cycle', 'start_date')
                    ->searchable()
                    ->preload(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
