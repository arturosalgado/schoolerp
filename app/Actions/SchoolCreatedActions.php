<?php

namespace App\Actions;

use App\Actions\Seeders\DocumentSeeder;

use App\Actions\Seeders\SeedProgramLevels;
use Lorisleiva\Actions\Concerns\AsAction;
use App\Models\School;
use Database\Seeders\RolesSeeder;

class SchoolCreatedActions
{
    use AsAction;

    public function handle(School $school, $user = null)
    {
        RolesSeeder::seedForSchool($school, $user);
        aLog($school->id,'roles seeded for recently create school ',$user,$school,'school_created');

        // give the user that created the school the admin role for that school
        if($user){
            $adminRole = $school->roles()->where('name', 'admin')->first();
            if($adminRole){
                $adminRole->users()->syncWithoutDetaching($user->id);
                aLog($school->id,'admin role assigned to user that created the school ',$user,$school,'');
            }
        }

        SeedProgramLevels::run($school);
        aLog($school->id,'program levels seeded for recently create school ',$user,$school,'school_created');

        DocumentSeeder::run($school);
        aLog($school->id,'documents seeded for recently create school ',$user,$school,'school_created');


    }
}
