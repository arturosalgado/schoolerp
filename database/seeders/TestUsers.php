<?php

namespace Database\Seeders;

use App\Models\School;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestUsers extends Seeder
{
    /**
     * Seed test school and test user.
     */
    public function run(): void
    {
        $school = School::updateOrCreate(
            ['slug' => 'testschool'],
            [
                'full_name' => 'TestSchool',
                'email' => 'testschool@icipuebla.com',
            ]
        );

        $user = User::updateOrCreate(
            ['email' => 'mago@icipuebla.com'],
            [
                'name' => 'Margarita',
                'password' => Hash::make('myrna101'),
            ]
        );

        $school->users()->syncWithoutDetaching([$user->id]);
    }
}
