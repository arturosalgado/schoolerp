<?php

namespace Database\Seeders;

use App\Actions\Seeders\BloodSeeder;
use App\Actions\Seeders\StatesSeeder;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        dump('seeding database...');
        dump('seeding states...');
        StatesSeeder::run();
        dump('seeding blood types...');
        BloodSeeder::run();

        $this->call([
            RolesSeeder::class,
            PermissionsSeeder::class,
            RolePermissionSeeder::class,
            TestUsers::class,
        ]);

       

        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
