<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    const ACTIONS = ['viewAny', 'view', 'create', 'update', 'delete'];

    const RESOURCES = [
        // Academic
        'students'           => 'academic',
        'teachers'           => 'academic',
        'prospects'          => 'academic',
        'enrollment-periods' => 'academic',
        'programs'           => 'academic',
        'cycles'             => 'academic',
        'terms'              => 'academic',
        'study-plans'        => 'academic',
        'terminals'          => 'academic',
        'documents'          => 'academic',
        // Administration
        'roles'              => 'administration',
        'permissions'        => 'administration',
        'users'              => 'administration',
        'schools'            => 'administration',
        'activity-log'       => 'administration',
    ];

    public function run(): void
    {
        foreach (self::RESOURCES as $resource => $panel) {
            foreach (self::ACTIONS as $action) {
                Permission::firstOrCreate(
                    ['resource' => $resource, 'action' => $action],
                    ['panel' => $panel]
                );
            }
        }
    }
}
