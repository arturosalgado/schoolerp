<?php

namespace App\Filament\Resources\Programs\Pages;

use App\Filament\Resources\Programs\ProgramResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProgram extends CreateRecord
{
    protected static string $resource = ProgramResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['school_id'] = school_id();
        return $data;
    }
}
