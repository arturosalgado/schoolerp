<?php

namespace App\MyFilament;

use Filament\Pages\Tenancy\RegisterTenant;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use App\Models\School;

class RegisterSchool extends RegisterTenant
{
    public static function canView(): bool
    {
        // Only show registration link if user has no schools
        return auth()->check() && auth()->user()->schools()->count() === 0;
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('slug')
                    ->unique('schools', 'slug')
                ,
                // ...
            ]);
    }
    public static function getLabel(): string
    {
        return  'Registrar Escuela';
    }

    protected function handleRegistration(array $data): School
    {
       // dd($data);
        $school = School::create($data);

        $school->users()->attach(auth()->user());

        return $school;
    }
}
