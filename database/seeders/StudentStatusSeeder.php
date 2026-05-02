<?php

namespace Database\Seeders;

use App\Models\School;
use App\Models\StudentStatus;
use Illuminate\Database\Seeder;

class StudentStatusSeeder extends Seeder
{
    private static array $defaults = [
        ['name' => 'Activo',   'description' => 'Estudiante activo',           'is_system' => true],
        ['name' => 'Egresado', 'description' => 'Estudiante egresado',         'is_system' => false],
        ['name' => 'Baja temporal',     'description' => 'Estudiante dado de baja, recuperable',     'is_system' => false],
        ['name' => 'Baja definitiva',   'description' => 'Estudiante dado de baja, no recuperable', 'is_system' => false],
        
    ];

    public function run(): void
    {
        School::all()->each(function (School $school) {
            foreach (self::$defaults as $status) {
                StudentStatus::updateOrCreate(
                    ['name' => $status['name'], 'school_id' => $school->id],
                    array_merge($status, ['school_id' => $school->id, 'active' => true])
                );
            }
        });
    }
}
