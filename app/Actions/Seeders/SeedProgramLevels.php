<?php

namespace App\Actions\Seeders;

use App\Models\ProgramLevel;
use App\Services\ProgramLevelService;
use Lorisleiva\Actions\Concerns\AsAction;

class SeedProgramLevels
{
    use AsAction;

    public function handle($school)
    {
        foreach (ProgramLevelService::$levels as $level){
            ProgramLevel::firstOrCreate(
                [
                    'name'=>$level,
                    'school_id'=>$school->id,
                ]
            );
        }
    }
}
