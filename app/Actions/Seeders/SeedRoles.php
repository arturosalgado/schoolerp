<?php

namespace App\Actions\Seeders;

use App\Models\Role;
use App\Services\RolesService;
use Lorisleiva\Actions\Concerns\AsAction;

class SeedRoles
{
    use AsAction;

    public function handle()
    {
        $roles = RolesService::$roles;
        foreach ($roles as $role=>$label){
            $roles = Role::firstOrCreate([
                'name'=>$role,
                'system'=>true,
                'level'=>'admin',
                'label_es'=>$label,
            ]);
        }
    }
}
