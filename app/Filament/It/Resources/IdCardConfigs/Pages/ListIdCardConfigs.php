<?php

namespace App\Filament\It\Resources\IdCardConfigs\Pages;

use App\Filament\It\Resources\IdCardConfigs\IdCardConfigResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListIdCardConfigs extends ListRecords
{
    protected static string $resource = IdCardConfigResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
