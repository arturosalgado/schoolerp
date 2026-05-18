<?php

namespace App\Filament\Resources\EnrollmentPeriods\Pages;

use App\Filament\Resources\EnrollmentPeriods\EnrollmentPeriodResource;
use App\Models\Cycle;
use App\Models\Program;
use App\Models\Term;
use Filament\Actions\CreateAction;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListEnrollmentPeriods extends ListRecords
{
    protected static string $resource = EnrollmentPeriodResource::class;

    public function mount(): void
    {
        $school = Filament::getTenant();

        if ($school) {
            $schoolId = $school->id;
            $hasCycles = Cycle::where('school_id', $schoolId)->exists();
            $hasTerms = Term::where('school_id', $schoolId)->exists();
            $hasPrograms = Program::where('school_id', $schoolId)->where('active', true)->exists();

            if (! $hasCycles || ! $hasTerms || ! $hasPrograms) {
                $missing = [];
                if (! $hasCycles) $missing[] = __('resources.cycles');
                if (! $hasTerms) $missing[] = __('fields.terms');
                if (! $hasPrograms) $missing[] = __('fields.programs');

                Notification::make()
                    ->warning()
                    ->title(__('fields.setup_progress'))
                    ->body(__('fields.school_configuration') . ': ' . implode(', ', $missing))
                    ->send();

                $this->redirect(Filament::getUrl());

                return;
            }
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
