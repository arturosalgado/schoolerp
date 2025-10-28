<?php

namespace App\Actions\Seeders;

use App\Models\State;
use App\Services\StateService;
use Lorisleiva\Actions\Concerns\AsAction;

class StatesSeeder
{
    use AsAction;

    public function handle()
    {
        foreach(StateService::$states as $state)
        {
            State::firstOrCreate([
                'name'=>$state
            ]);
        }
    }
}
