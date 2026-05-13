<?php

namespace App\Filament\It\Resources\Terms\Pages;

use App\Filament\It\Resources\Terms\TermResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTerm extends CreateRecord
{
    protected static string $resource = TermResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['school_id'] = school_id();

        return $data;
    }
}
