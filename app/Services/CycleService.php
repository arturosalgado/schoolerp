<?php

namespace App\Services;

use App\Models\Cycle;

class CycleService
{
    public static function run($school_id)
    {
        $start = date('Y-08-01');
        $end = date('Y-07-15', strtotime('+1 year', strtotime($start)));
        // TODO: implement cycle year lookup
        Cycle::firstOrCreate(
            [
                'start_date' => $start,
                'end_date' => $end,
                'school_id' => $school_id,
                'is_active' => true,
            ]
        );
    }
}
