<?php

namespace App\Filament\It\Resources\IdCardConfigs\Pages;

use App\Filament\It\Resources\IdCardConfigs\IdCardConfigResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditIdCardConfig extends EditRecord
{
    protected static string $resource = IdCardConfigResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
