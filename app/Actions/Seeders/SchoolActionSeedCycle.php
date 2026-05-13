<?php

namespace App\Actions\Seeders;

use App\Models\School;
use App\Services\CycleService;

class SchoolActionSeedCycle
{
    public static function runForSchool(School $school): void
    {
        CycleService::run($school->id);
    }
}
