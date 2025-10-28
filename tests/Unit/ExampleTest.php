<?php

namespace Tests\Unit;

use App\Jobs\ProcessStudentPhotos;
use App\Models\Student;
#use PHPUnit\Framework\TestCase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_that_true_is_true(): void
    {
        $mat = '9090';
        $s = Student::firstOrNew(
            ['enrollment' => $mat],
        );
        $s->name = 'pp';
        $s->email = 'pp@pp.com';
        $s->program= 'Derecho';
        $s->school_id=1;
        //after this i want to remove program=Derecho
        unset($s->program);;
        $s->save();
        dump($s);



    }
}
