<?php

namespace App\Filament\It\Resources\Users\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nombres')
                    ->label('Nombre(s)')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('paterno')
                    ->label('Apellido Paterno')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('materno')
                    ->label('Apellido Materno')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Correo Electrónico')
                    ->searchable()
                    ->sortable(),
                ToggleColumn::make('active')
                    ->label('Activo')
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                Action::make('cambiarContrasena')
                    ->label('Cambiar Contraseña')
                    ->modalWidth('md')
                    ->form([
                        TextInput::make('password')
                            ->label('Nueva Contraseña')
                            ->password()
                            ->required()
                            ->minLength(8),
                        TextInput::make('password_confirmation')
                            ->label('Confirmar Contraseña')
                            ->password()
                            ->required()
                            ->same('password'),
                    ])
                    ->action(function ($record, array $data) {
                        $record->update([
                            'password' => Hash::make($data['password']),
                        ]);
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
