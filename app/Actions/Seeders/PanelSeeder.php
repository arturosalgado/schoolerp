<?php

namespace App\Actions\Seeders;

use App\Models\Panel;
use App\Models\State;
use App\Services\RolesService;
use App\Services\StateService;
use Lorisleiva\Actions\Concerns\AsAction;

class PanelSeeder
{
    use AsAction;

    public function handle()
    {
        //$panels = ['admin'=>'Admin','it'=>'Informática','finance'=>'Finanzas'];
        $panels =RolesService::$roles;

        foreach ($panels as $panel=>$label){
            Panel::firstOrCreate([
                'name'=>$panel,
                'displayNameEs'=>$label,
            ]);
        }
    }
}
