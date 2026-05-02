<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('photo')
                    ->label('Foto')
                    ->disk('public')
                    ->height(40)
                    ->width(40)
                    ->defaultImageUrl('data:image/svg+xml;base64,' . base64_encode('<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40"><rect width="40" height="40" fill="#e5e7eb"/><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="#9ca3af" font-size="16">?</text></svg>')),
                TextColumn::make('last_name')
                    ->label('Apellido Paterno')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('second_last_name')
                    ->label('Apellido Materno')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Nombre(s)')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Correo Electrónico')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('roles.label_es')
                    ->label('Roles')
                    ->badge()
                    ->searchable(),
ToggleColumn::make('active')
                    ->label('Activo')
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                Action::make('restablecerContrasena')
                    ->label('Restablecer Contraseña')
                    ->icon('heroicon-o-key')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $status = Password::sendResetLink(['email' => $record->email]);
                        
                        if ($status === Password::RESET_LINK_SENT) {
                            Notification::make()
                                ->title('Correo de restablecimiento enviado')
                                ->success()
                                ->send();
                        } else {
                            Notification::make()
                                ->title('Error al enviar correo')
                                ->body($status)
                                ->danger()
                                ->send();
                        }
                    }),
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
