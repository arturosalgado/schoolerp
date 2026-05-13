<?php

namespace App\Filament\Resources\EnrollmentPeriods\Tables;

use App\Tables\EnrollmentPeriods\EnrollmentPeriodTable;
use Filament\Tables\Table;

class EnrollmentPeriodsTable
{
    public static function configure(Table $table): Table
    {
        return EnrollmentPeriodTable::getTable($table);
    }
}
