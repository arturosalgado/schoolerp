<?php

namespace App\Filament\Tables\Columns;

use Filament\Tables\Columns\Column;
use Illuminate\Support\Facades\Storage;
class StudentColumn extends Column
{
    protected string $view = 'filament.tables.columns.student-column';

    public function getImageUrl(){
        $name = config('filament.default_filesystem_disk');

        $storage = Storage::disk($name);
        return $storage->url($this->getState());

    }
}
