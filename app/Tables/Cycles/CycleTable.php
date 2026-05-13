<?php

namespace App\Tables\Cycles;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class CycleTable
{
    public static function getTable(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('start_date')
                    ->label(__('fields.start_date'))
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('end_date')
                    ->label(__('fields.end_date'))
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

                TextColumn::make('created_at')
                    ->label(__('fields.created_at'))
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('is_active')
                    ->label(__('fields.is_active')),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('start_date', 'desc');
    }
}
