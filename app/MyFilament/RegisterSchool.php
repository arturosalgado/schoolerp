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
                TextInput::make('full_name')
                    ->label(__('school_name'))
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set) {
                        $stopWords = ['de', 'del', 'la', 'las', 'los', 'el', 'y', 'e', 'o', 'u', 'a', 'en', 'para', 'por', 'con', 'sin', 'sobre', 'entre'];
                        $words = array_filter(
                            explode(' ', trim($state)),
                            fn($w) => $w !== '' && !in_array(strtolower($w), $stopWords)
                        );
                        $initials = implode('', array_map(fn($w) => strtolower($w[0]), $words));
                        $set('slug', $initials);
                    }),
                TextInput::make('slug')
                    ->label('Slug')
                    ->readOnly()
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
        $school = School::create($data);

        $school->users()->attach(auth()->user());

        return $school;
    }
}
