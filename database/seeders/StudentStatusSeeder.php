<?php

namespace Database\Seeders;

use App\Models\School;
use App\Models\StudentStatus;
use Illuminate\Database\Seeder;
// IMPORTANT, THIS IS MEANT TO BE ONLY WHEN A SCHOOL IS CREATED, IS NOT A GLOBAL SEEDER
class StudentStatusSeeder extends Seeder
{
    private static array $defaults = [
        ['name' => 'Activo',   'description' => 'Estudiante activo',           'is_system' => true],
        ['name' => 'Egresado', 'description' => 'Estudiante egresado',         'is_system' => false],
        ['name' => 'Baja temporal',     'description' => 'Estudiante dado de baja, recuperable',     'is_system' => false],
        ['name' => 'Baja definitiva',   'description' => 'Estudiante dado de baja, no recuperable', 'is_system' => false],
        
    ];

    static public function runForSchool(School $school): void
    {
        foreach (self::$defaults as $status) {
            StudentStatus::firstOrCreate(
                ['school_id' => $school->id, 'name' => $status['name']],
                ['description' => $status['description'], 'is_system' => $status['is_system']]
            );
        }
    }
}
