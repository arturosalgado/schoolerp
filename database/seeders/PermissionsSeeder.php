<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
 
    const PANELS = ['admin', 'it'];

    const ACTIONS = ['viewAny', 'view', 'create', 'update', 'delete','duplicate'];

    const RESOURCES = [
        
       'students',
       'teachers',
       'subjects',
    ];

    public function run(): void
    {
        foreach (self::RESOURCES as $resource ) {
            foreach (self::ACTIONS as $action) {
                Permission::firstOrCreate(
                    ['resource' => $resource, 'action' => $action],
                   
                );
            }
        }
    }
}
