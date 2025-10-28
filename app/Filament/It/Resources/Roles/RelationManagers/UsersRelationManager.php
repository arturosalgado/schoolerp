<?php

namespace App\Filament\InformationTechnology\Resources\Roles\RelationManagers;

use App\Filament\InformationTechnology\Resources\Users\UserResource;
use App\Models\School;
use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersRelationManager extends RelationManager
{
    protected static string $relationship = 'users';
    protected static ?string $title = 'Usuarios';
    protected static ?string $label = 'Usuarios';
    protected static ?string $pluralLabel = 'Usuarios';

    // protected static ?string $relatedResource = UserResource::class;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('name')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->unique('users', 'email')
                    ->maxLength(255),
                TextInput::make('password')
                    ->label('Contraseña')
                    ->password()
                    ->required()
                    ->minLength(8)
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state)),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('type')
                    ->label('User Type')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Agregar Usuario')
                    ->mutateDataUsing(function (array $data): array {
                       // $data['school_id'] = school_id();
                        //$data['panel'] = 'information_technology';
                        return $data;
                    })
                    ->after(function ($record) {
                        // Attach the user to the current role
                        //$this->getOwnerRecord()->users()->attach($record); this should happen automatically
                       // $school = School::find(school_id());
                     //   $school->users()->attach($record);// get attached to the school, or else. Ya lo hace, automaticamente
                        $record->email_verified_at = now();// for created users from the app, dont ask for this, this is only for external users
                        $record->save();// esto hace que no se pida la confirmacion del email
                        // Force logout by clearing all sessions for this user
                        $record->invalidateAllSessions();
                    }),
                AttachAction::make(),
            ])
            ->recordActions([
                DetachAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DetachBulkAction::make(),
                ]),
            ])
            ->paginated(false);
    }
}
