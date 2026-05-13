<?php

namespace App\Filament\Resources\Cycles\Tables;

use App\Tables\Cycles\CycleTable;
use Filament\Tables\Table;

class CyclesTable
{
    public static function configure(Table $table): Table
    {
        return CycleTable::getTable($table);
    }
}
