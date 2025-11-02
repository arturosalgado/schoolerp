<?php

namespace Tests\Unit;

use App\Actions\Seeders\SeedRoles;
use App\Jobs\ProcessStudentPhotos;
use App\Models\Student;
#use PHPUnit\Framework\TestCase;
use App\Services\PermissionsService;
use App\Services\RolesService;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_that_true_is_true(): void
    {


        $roles = RolesService::$roles;

        SeedRoles::run();
        dd($roles);


    }
}
