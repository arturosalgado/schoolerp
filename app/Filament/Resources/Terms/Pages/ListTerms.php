<?php

namespace App\Filament\Resources\Terms\Pages;

use App\Filament\Resources\Terms\TermResource;
use App\Models\Cycle;
use Filament\Actions\CreateAction;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListTerms extends ListRecords
{
    protected static string $resource = TermResource::class;

    public function mount(): void
    {
        if (! Cycle::where('school_id', school_id())->exists()) {
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
