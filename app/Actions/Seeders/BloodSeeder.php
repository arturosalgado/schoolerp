<?php

namespace App\Actions\Seeders;

use App\Models\BloodType;
use App\Services\BloodTypeService;
use Lorisleiva\Actions\Concerns\AsAction;

class BloodSeeder
{
    use AsAction;

    public function handle():void
    {
        foreach(BloodTypeService::$types as $type)
        {
            BloodType::firstOrCreate([
                'name'=>$type
            ]);
        }
    }
}
