<?php

namespace App\Filament\It\Resources\Programs\Pages;

use App\Filament\It\Resources\Programs\ProgramResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProgram extends CreateRecord
{
    protected static string $resource = ProgramResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['school_id'] = tenant()?->id;

        return $data;
    }
}
