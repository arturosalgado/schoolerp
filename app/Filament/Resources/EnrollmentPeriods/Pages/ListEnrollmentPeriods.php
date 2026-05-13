<?php

namespace App\Filament\Resources\EnrollmentPeriods\Pages;

use App\Filament\Resources\EnrollmentPeriods\EnrollmentPeriodResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEnrollmentPeriods extends ListRecords
{
    protected static string $resource = EnrollmentPeriodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
