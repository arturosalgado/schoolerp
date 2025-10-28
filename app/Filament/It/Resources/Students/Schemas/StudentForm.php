<?php

namespace App\Filament\It\Resources\Students\Schemas;

use App\Actions\SetupIci;
use App\Schemas\Students\StudentSections;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class StudentForm
{
    public static function configure(Schema $schema): Schema
    {

  return $schema
      ->components([

            StudentSections::getPersonalData('it')->columnSpan(2)
          ,
            StudentSections::getPhoto('it')->columnSpan(1),
          StudentSections::getContactData('it')->columnSpan(3),
          StudentSections::getProgramsOfStudy()->columnSpan(3),

      ])->columns([
          'xl' =>3,
          '2xl' => 3,
      ]);


    }
}
