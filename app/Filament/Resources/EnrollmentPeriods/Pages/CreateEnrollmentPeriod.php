<?php

namespace App\Filament\Resources\EnrollmentPeriods\Pages;

use App\Filament\Resources\EnrollmentPeriods\EnrollmentPeriodResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEnrollmentPeriod extends CreateRecord
{
    protected static string $resource = EnrollmentPeriodResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['school_id'] = school_id();

        return $data;
    }
}
