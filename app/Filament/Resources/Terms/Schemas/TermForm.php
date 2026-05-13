<?php

namespace App\Filament\Resources\Terms\Schemas;

use App\Schemas\Terms\TermSections;
use Filament\Schemas\Schema;

class TermForm
{
    public static function configure(Schema $schema): Schema
    {
        return TermSections::getForm($schema);
    }
}
