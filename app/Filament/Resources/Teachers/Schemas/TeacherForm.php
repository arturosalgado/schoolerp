<?php

namespace App\Filament\Resources\Teachers\Schemas;

use App\Schemas\Teachers\TeacherSections;
use Filament\Schemas\Schema;

class TeacherForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TeacherSections::getPersonalData()->columnSpan(2),
                TeacherSections::getPhoto()->columnSpan(1),
                TeacherSections::getContactData()->columnSpan(3),
            ])
            ->columns([
                'xl' => 3,
                '2xl' => 3,
            ]);
    }
}
