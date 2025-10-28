<?php

namespace App\Filament\It\Resources\Students\Pages;

use App\Filament\It\Resources\Students\StudentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateStudent extends CreateRecord
{
    protected static string $resource = StudentResource::class;
}
