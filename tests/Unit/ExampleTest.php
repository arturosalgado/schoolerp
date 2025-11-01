<?php

namespace Tests\Unit;

use App\Jobs\ProcessStudentPhotos;
use App\Models\Student;
#use PHPUnit\Framework\TestCase;
use App\Services\PermissionsService;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_that_true_is_true(): void
    {


        $permissions = PermissionsService::getPermissions();
        dd($permissions);



    }
}
