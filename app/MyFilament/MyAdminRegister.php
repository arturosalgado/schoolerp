<?php

namespace App\MyFilament;

use Filament\Auth\Pages\Register as FilamentRegister;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class MyAdminRegister extends FilamentRegister
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->getPaternoFormComponent(),
                $this->getMaternoFormComponent(),
                $this->getNombresFormComponent(),
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
            ]);
    }

    protected function getPaternoFormComponent(): Component
    {
        return TextInput::make('last_name')
            ->label('Apellido Paterno')
            ->required()
            ->maxLength(80)
            ->autofocus();
    }

    protected function getMaternoFormComponent(): Component
    {
        return TextInput::make('second_last_name')
            ->label('Apellido Materno')
            ->maxLength(80);
    }

    protected function getNombresFormComponent(): Component
    {
        return TextInput::make('name')
            ->label('Nombre(s)')
            ->required()
            ->maxLength(80);
    }

    protected function getPasswordConfirmationFormComponent(): Component
    {
        return TextInput::make('passwordConfirmation')
            ->label(__('filament-panels::auth/pages/register.form.password_confirmation.label'))
            ->password()
            ->revealable(filament()->arePasswordsRevealable())
            ->required()
            ->dehydrated(false);
    }

    protected function handleRegistration(array $data): Model
    {
        // Combine name parts into the 'name' field for database compatibility
        $data['name'] = trim("{$data['last_name']} {$data['second_last_name']} {$data['name']}");
        
        return $this->getUserModel()::create($data);
    }
}
