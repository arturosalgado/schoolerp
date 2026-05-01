<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    
    const SUPER_PERMISSIONS = [[
        "resource"=> "*",
        'permissions'=>'*'        
    ]];

     /**
     * Permissions that should NOT be granted to admin role.
     */   

    /**
     * Permissions granted to teacher role.
     */
    const PERMISSIONS = [
        'super'=>[
            'resource'=> '*',
            'permissions'=>'*'
        ],
        'admin'=> 
        [
                [
                    "resource"=> "students",
                    'permissions'=>'*'
                ],
                [
                    "resource"=> "teachers",
                    'permissions'=>'*'
                ],
                [
                    "resource"=> "subjects",
                    'permissions'=>'*'
                ],
        ],
        'teacher'=>[
            [
                "resource"=> "students",
                'permissions'=>['viewAny','view']
            ],
            [
                "resource"=> "subjects",
                'permissions'=>['viewAny','view']                
            ]
        ],
        'student'=>[
            ['resource'=> 'grades',
            'permissions'=>['viewAny','view']]
        ],
        'prospect'=>[
            [
                'resource'=>'prospects',
                'permissions'=>['view','create','update']
            ]  // no permissions
        ],
    ];

    /**
     * Permissions granted to student role.
     */
    const STUDENT_PERMISSIONS = [
        'students.view',
    ];

    public function run(): void
    {
        $allPermissions = Permission::all();
        $roles = Role::all()->pluck('name')->toArray();
        $role_keys = array_flip($roles);
        dump($role_keys);
        $roleKeys = array_flip(array_keys(self::PERMISSIONS));
        dump($roleKeys);

        if (array_diff_key($role_keys, $roleKeys)!==[]) {
            print_r(array_diff_key($role_keys, $roleKeys));
            throw new \Exception('Some roles in the database do not have defined permissions in RolePermissionSeeder::PERMISSIONS.');
        }
        

        foreach($roles as $role){

           // $this->suncPermissions($role,$permissions);
        }

        // prospect — no permissions
        // (intentionally left empty)
    }

    private function syncPermissions(Role $role, array $permissionNames): void
    {
        $ids = Permission::whereIn('name', $permissionNames)
            ->pluck('id')
            ->mapWithKeys(fn($id) => [$id => ['active' => true]])
            ->toArray();

        $role->permissions()->sync($ids);
    }
}
