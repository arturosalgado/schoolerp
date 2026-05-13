<?php

namespace App\Filament\Resources\Cycles\Schemas;

use App\Schemas\Cycles\CycleSections;
use Filament\Schemas\Schema;

class CycleForm
{
    public static function configure(Schema $schema): Schema
    {
        return CycleSections::getForm($schema);
    }
}
