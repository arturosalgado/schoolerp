<?php

namespace App\Filament\Resources\EnrollmentPeriods\Schemas;

use App\Schemas\EnrollmentPeriods\EnrollmentPeriodSections;
use Filament\Schemas\Schema;

class EnrollmentPeriodForm
{
    public static function configure(Schema $schema): Schema
    {
        return EnrollmentPeriodSections::getForm($schema);
    }
}
