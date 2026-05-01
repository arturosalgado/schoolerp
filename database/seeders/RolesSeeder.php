<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\School;
use App\Models\User;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    public const ROLES = [
        [
            'name'        => 'super',
            'label_es'    => 'Super Administrador',// it is ok, may be the case like Felipe who needed to make changes everywhere 
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
        //seeds per school
    }

    public static function seedForSchool(School $school, User $user): void
    {
        foreach (self::ROLES as $data) {
            $role = Role::firstOrCreate(
                ['name' => $data['name'], 'school_id' => $school->id],
                array_merge($data, ['school_id' => $school->id])
            );

            
        }
    }
}
