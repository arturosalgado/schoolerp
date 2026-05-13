<?php

namespace App\Tables\Terms;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class TermTable
{
    public static function getTable(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('fields.name'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('cycle.start_date')
                    ->label(__('fields.cycle'))
                    ->date('Y')
                    ->sortable(),

                TextColumn::make('start_date')
                    ->label(__('fields.start_date'))
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('end_date')
                    ->label(__('fields.end_date'))
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('order')
                    ->label(__('fields.order'))
                    ->sortable(),

                IconColumn::make('is_active')
                    ->label(__('fields.is_active'))
                    ->boolean()
                    ->trueIcon(Heroicon::OutlinedCheckCircle)
                    ->falseIcon(Heroicon::OutlinedXCircle)
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->sortable(),
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
            ->defaultSort('order', 'asc');
    }
}
