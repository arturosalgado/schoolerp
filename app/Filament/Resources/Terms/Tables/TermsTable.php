<?php

namespace App\Filament\Resources\Terms\Tables;

use App\Tables\Terms\TermTable;
use Filament\Tables\Table;

class TermsTable
{
    public static function configure(Table $table): Table
    {
        return TermTable::getTable($table);
    }
}
