<?php

namespace App\Actions\Seeders;

use App\Models\BloodType;
use App\Models\Document;
use App\Services\BloodTypeService;
use App\Services\DocumentServices;
use Lorisleiva\Actions\Concerns\AsAction;

class DocumentSeeder
{
    use AsAction;

    public function handle($school):void
    {
        foreach(DocumentServices::$documents as $document)
        {
            Document::firstOrCreate([
                'name'=>$document,
                'school_id'=>$school->id,
            ]);
        }
    }
}
