<?php

namespace App\Actions;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateRootUser
{
    use AsAction;

    public function handle()
    {
        $u = User::firstOrCreate([
            'name' => 'Arturo de los Angeles',
            'email' => 'arturodelosangeles@live.com',
            'password' => Hash::make('myrna101'),
        ]);
        dump($u);

    }
}
