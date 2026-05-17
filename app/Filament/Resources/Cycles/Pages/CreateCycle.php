<?php

namespace App\Filament\Resources\Cycles\Pages;

use App\Filament\Resources\Cycles\CycleResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCycle extends CreateRecord
{
    protected static string $resource = CycleResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['school_id'] = school_id();

        return $data;
    }

    protected function getDefaultFormData(): array
    {
        return [
            'start_date' => request()->query('start_date'),
            'end_date' => request()->query('end_date'),
        ];
    }
}
