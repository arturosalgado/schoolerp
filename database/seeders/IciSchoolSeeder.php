<?php

namespace Database\Seeders;

use App\Models\Cycle;
use App\Models\ProgramLevel;
use App\Models\Role;
use App\Models\School;
use App\Models\Term;
use App\Models\TermName;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class IciSchoolSeeder extends Seeder
{
    public function run(): void
    {
        // Create the school (triggers SchoolCreatedActions which seeds roles, program levels, etc.)
        $school = School::firstOrCreate(
            ['slug' => 'ici'],
            ['full_name' => 'Instituto de Ciencias Jurídicas']
        );

        // Create the user
        $user = User::updateOrCreate(
            ['email' => 'margarita@ici.com'],
            [
                'name' => 'Margarita',
                'password' => Hash::make('Myrna101!@'),
            ]
        );

        // Ensure roles are seeded (in case school already existed)
        RolesSeeder::seedForSchool($school, $user);

        // Attach user to school
        $school->users()->syncWithoutDetaching([$user->id]);

        // Assign the information_technology role
        $itRole = Role::where('name', 'information_technology')
            ->where('school_id', $school->id)
            ->first();

        if ($itRole) {
            $itRole->users()->syncWithoutDetaching([$user->id]);
        }

        // Seed cycle Aug 15 2026 - Jul 15 2027
        $cycle = Cycle::firstOrCreate(
            [
                'school_id' => $school->id,
                'start_date' => '2026-08-15',
            ],
            [
                'end_date' => '2027-07-15',
                'is_active' => true,
            ]
        );

        // Seed academic level
        ProgramLevel::firstOrCreate(
            ['school_id' => $school->id, 'name' => 'Licenciatura'],
            ['active' => true]
        );

        // Seed term name
        TermName::firstOrCreate([
            'school_id' => $school->id,
            'name' => 'Primavera',
        ]);

        // Seed term Aug 15 2026 - Dec 15 2026
        Term::firstOrCreate(
            [
                'school_id' => $school->id,
                'cycle_id' => $cycle->id,
                'name' => 'Primavera',
            ],
            [
                'start_date' => '2026-08-15',
                'end_date' => '2026-12-15',
                'is_active' => true,
                'order' => 1,
            ]
        );
    }
}
