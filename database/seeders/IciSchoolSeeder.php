<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\School;
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

        // Attach user to school
        $school->users()->syncWithoutDetaching([$user->id]);

        // Assign the information_technology role
        $itRole = Role::where('name', 'information_technology')
            ->where('school_id', $school->id)
            ->first();

        if ($itRole) {
            $itRole->users()->syncWithoutDetaching([$user->id]);
        }
    }
}
