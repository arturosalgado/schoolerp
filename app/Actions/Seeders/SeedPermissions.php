<?php

namespace App\Actions\Seeders;

use App\Models\Permission;
use App\Services\PermissionsService;
use Lorisleiva\Actions\Concerns\AsAction;

class SeedPermissions
{
    use AsAction;

    public function handle()
    {
        $permissions = PermissionsService::getPermissions();
        foreach($permissions as $permission){
            Permission::firstOrCreate(
                [
                    'panel'=>$permission['panel'],
                    'action'=>$permission['action'],
                    'resource'=>$permission['resource'],
                    'resource_es'=> $permission['action_es']. ' '.$permission['resource_es'],

                ]
            );
        }
    }
}
