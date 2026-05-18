<?php

namespace App\Filament\Resources\Programs\Pages;

use App\Filament\Resources\Programs\ProgramResource;
use App\Models\Cycle;
use Filament\Actions\CreateAction;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListPrograms extends ListRecords
{
    protected static string $resource = ProgramResource::class;

    public function mount(): void
    {
        $schoolId = school_id();

        if (! Cycle::where('school_id', $schoolId)->exists()) {
            Notification::make()
                ->warning()
                ->title(__('fields.cycles_required_title'))
                ->body(__('fields.school_cycles_description'))
                ->send();

            $this->redirect(Filament::getUrl());

            return;
        }

        parent::mount();
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
