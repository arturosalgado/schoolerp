<?php

namespace App\Actions\Seeders;

use App\Models\Panel;
use App\Models\Permission;
use App\Models\Role;
use App\Services\PermissionsService;
use App\Services\RolesService;
use Lorisleiva\Actions\Concerns\AsAction;

class SeedRoles
{
    use AsAction;

    public function handle($school_id=null, $user_id=null)
    {

        $roles = RolesService::$roles;
        //dd($roles);
        foreach ($roles as $panel=>$label){
            //dd($label);
            $role = Role::firstOrCreate([
                'name'=>$panel,
                'system'=>true,
                'level'=>'admin',
                'label_es'=>$label,
                'school_id'=>$school_id,
            ]);

            $role->panels()->sync(Panel::where('name',$panel)->pluck('id'));
            $this->attachPermissions($role,$panel);

            if ($user_id){
               // dd($user_id);
                $role->users()->sync($user_id);
            }

        }
    }

    protected function attachPermissions($role,$panel){
        $permissionIds = Permission::where('panel',$panel)->pluck('id');
        $role->permissions()->syncWithPivotValues($permissionIds, ['active' => true]);
    }


}
