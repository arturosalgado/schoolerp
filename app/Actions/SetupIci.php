<?php

namespace App\Actions;

use App\Models\Program;
use App\Models\ProgramLevel;
use App\Models\School;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Lorisleiva\Actions\Concerns\AsAction;

class SetupIci
{
    use AsAction;

    public function handle()
    {
        $s = School::firstOrCreate(
            [
                'slug' => 'ici',

            ]
        );

       $u = User::firstOrCreate(
           [
               'name'=>'Margarita',
               'email'=>'soporte@icipuebla.edu.mx',
               'password'=>Hash::make('Admin101!@'),
           ]
       );

       $s->users()->sync([$u->id]);
       $root = User::find(1);
       if ($root) {
           $root->schools()->sync([$s->id]);
       }

       $level = ProgramLevel::where('school_id', $s->id)->where('name','Licenciatura')->firstOrFail();
       $program = Program::firstOrCreate([
           'name'=>'Derecho',
           'program_level_id'=>$level->id,
           'school_id'=>$s->id,
       ]);

       $program2 = Program::firstOrCreate([
            'name'=>'Psicologia',
            'program_level_id'=>$level->id,
            'school_id'=>$s->id,
       ]);



    }
}
