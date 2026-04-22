<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    public const ROLES = [
        [
            'name'        => 'super',
            'label_es'    => 'Super Administrador',
            'description' => 'Full system-wide access.',
            'system'      => true,
            'is_active'   => true,
        ],
        [
            'name'        => 'admin',
            'label_es'    => 'Administrador',
            'description' => 'Full access within their school.',
            'system'      => true,
            'is_active'   => true,
        ],
        [
            'name'        => 'teacher',
            'label_es'    => 'Docente',
            'description' => 'Teaching staff access.',
            'system'      => true,
            'is_active'   => true,
        ],
        [
            'name'        => 'student',
            'label_es'    => 'Alumno',
            'description' => 'Enrolled student access.',
            'system'      => true,
            'is_active'   => true,
        ],
        [
            'name'        => 'prospect',
            'label_es'    => 'Prospecto',
            'description' => 'Prospective student access.',
            'system'      => true,
            'is_active'   => true,
        ],
    ];

    public function run(): void
    {
        foreach (self::ROLES as $role) {
            Role::firstOrCreate(['name' => $role['name']], $role);
        }
    }
}
