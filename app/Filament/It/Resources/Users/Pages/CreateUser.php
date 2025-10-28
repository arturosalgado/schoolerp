<?php

namespace App\Filament\It\Resources\Users\Pages;

use App\Filament\It\Resources\Users\UserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
}
