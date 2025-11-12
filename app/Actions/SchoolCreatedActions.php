<?php

namespace App\Actions;

use App\Actions\Seeders\DocumentSeeder;
use App\Actions\Seeders\SeedProgramLevels;
use App\Actions\Seeders\SeedRoles;
use Lorisleiva\Actions\Concerns\AsAction;

class SchoolCreatedActions
{
    use AsAction;

    public function handle($school, $user = null)
    {
        SeedRoles::run($school, $user);

        aLog($school->id,'roles seeded for recently create school ',$user,$school,'school_created');



        SeedProgramLevels::run($school);
        aLog($school->id,'program levels seeded for recently create school ',$user,$school,'school_created');

        DocumentSeeder::run($school);
        aLog($school->id,'documents seeded for recently create school ',$user,$school,'school_created');


    }
}
