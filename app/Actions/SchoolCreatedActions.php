<?php

namespace App\Actions;

use App\Actions\Seeders\SeedProgramLevels;
use App\Actions\Seeders\SeedRoles;
use Lorisleiva\Actions\Concerns\AsAction;

class SchoolCreatedActions
{
    use AsAction;

    public function handle($school_id, $user_id = null)
    {
        SeedRoles::run($school_id, $user_id);
        SeedProgramLevels::run($school_id);
    }
}
