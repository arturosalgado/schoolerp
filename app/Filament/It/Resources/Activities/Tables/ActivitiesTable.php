<?php

namespace App\Filament\It\Resources\Activities\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ActivitiesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('id', 'desc')
            ->columns([
                TextColumn::make('school.id')
                    ->searchable(),
                TextColumn::make('level')
                    ->searchable(),
                TextColumn::make('log_name')
                    ->searchable(),
                TextColumn::make('subject_type')
                    ->searchable(),
                TextColumn::make('event')
                    ->searchable(),
                TextColumn::make('subject_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('causer_type')
                    ->searchable(),
                TextColumn::make('causer_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('batch_uuid')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([











            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
