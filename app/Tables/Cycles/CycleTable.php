<?php

namespace App\Tables\Cycles;

use App\Models\Cycle;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
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
                Action::make('duplicate')
                    ->label(__('resources.duplicate'))
                    ->icon(Heroicon::OutlinedDocumentDuplicate)
                    ->form(fn (Cycle $record) => [
                        DatePicker::make('start_date')
                            ->label(__('fields.start_date'))
                            ->required()
                            ->default($record->start_date->addYear()->format('Y-m-d')),
                        DatePicker::make('end_date')
                            ->label(__('fields.end_date'))
                            ->required()
                            ->default($record->end_date->addYear()->format('Y-m-d')),
                        Toggle::make('is_active')
                            ->label(__('fields.is_active'))
                            ->default(false),
                    ])
                    ->action(function (array $data): void {
                        Cycle::create([
                            'start_date' => $data['start_date'],
                            'end_date' => $data['end_date'],
                            'is_active' => $data['is_active'],
                            'school_id' => school_id(),
                        ]);

                        Notification::make()
                            ->success()
                            ->title(__('resources.cycle_duplicated'))
                            ->send();
                    })
                    ->modalHeading(__('resources.duplicate') . ' ' . __('fields.cycle')),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('start_date', 'desc');
    }
}
