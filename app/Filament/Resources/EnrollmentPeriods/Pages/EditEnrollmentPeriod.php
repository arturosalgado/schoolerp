<?php

namespace App\Filament\Resources\EnrollmentPeriods\Pages;

use App\Filament\Resources\EnrollmentPeriods\EnrollmentPeriodResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditEnrollmentPeriod extends EditRecord
{
    protected static string $resource = EnrollmentPeriodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
