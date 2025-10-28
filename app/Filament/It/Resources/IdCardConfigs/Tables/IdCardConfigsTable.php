<?php

namespace App\Filament\It\Resources\IdCardConfigs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\Action;
class IdCardConfigsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('name')->label('Nombre'),

                IconColumn::make('active')
                    ->label('Activa')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('gray')
                    ->alignCenter(),

                ImageColumn::make('front_path')
                    ->label('Plantilla Frontal')
                    ->disk('s3')
                    ->visibility('private')
                    ->height(100)
                    ->width(100),

                ImageColumn::make('back_path')
                    ->label('Plantilla Trasera')
                    ->disk('s3')
                    ->visibility('private')
                    ->height(100)
                    ->width(100),

//                TextColumn::make('photo_x')
//                    ->label('Foto X')
//                    ->suffix('px')
//                    ->sortable(),
//
//                TextColumn::make('photo_y')
//                    ->label('Foto Y')
//                    ->suffix('px')
//                    ->sortable(),

                TextColumn::make('photo_width')
                    ->label('Ancho')
                    ->suffix('px')
                    ->sortable(),

                TextColumn::make('font')->label('Fuente'),
                TextColumn::make('size')->label('Tamaño'),
                ColorColumn::make('color')->label('Color'),


            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),

            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
