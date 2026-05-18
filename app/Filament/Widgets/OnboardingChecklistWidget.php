<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Cycles\CycleResource;
use App\Filament\Resources\Programs\ProgramResource;
use App\Filament\Resources\Terms\TermResource;
use App\Models\Cycle;
use App\Models\Program;
use App\Models\Term;
use Filament\Facades\Filament;
use Filament\Widgets\Widget;

class OnboardingChecklistWidget extends Widget
{
    protected static ?int $sort = -2;

    protected static bool $isLazy = false;

    protected string $view = 'filament.widgets.onboarding-checklist-widget';

    protected int | string | array $columnSpan = 1;

    public static function canView(): bool
    {
        $school = Filament::getTenant();

        if (! $school) {
            return false;
        }

        return ! static::isSetupComplete($school);
    }

    public function getChecklistItems(): array
    {
        $school = Filament::getTenant();

        return [
            [
                'key' => 'cycles',
                'label' => __('fields.school_cycles'),
                'description' => __('fields.school_cycles_description'),
                'complete' => Cycle::where('school_id', $school->id)->exists(),
                'url' => $this->getCyclesUrl(),
                'icon' => 'heroicon-o-calendar-days',
            ],
            [
                'key' => 'terms',
                'label' => __('fields.terms'),
                'description' => __('fields.terms_description'),
                'complete' => Term::where('school_id', $school->id)->exists(),
                'url' => $this->getTermsUrl(),
                'icon' => 'heroicon-o-clock',
            ],
            [
                'key' => 'programs',
                'label' => __('fields.programs'),
                'description' => __('fields.programs_description'),
                'complete' => Program::where('school_id', $school->id)->exists(),
                'url' => $this->getProgramsUrl(),
                'icon' => 'heroicon-o-academic-cap',
            ],
        ];
    }

    public function getCompletedCount(): int
    {
        return collect($this->getChecklistItems())->where('complete', true)->count();
    }

    public function getTotalCount(): int
    {
        return count($this->getChecklistItems());
    }

    protected static function isSetupComplete($school): bool
    {
        return Cycle::where('school_id', $school->id)->exists()
            && Term::where('school_id', $school->id)->exists()
            && Program::where('school_id', $school->id)->exists();
    }

    protected function getCyclesUrl(): string
    {
        return CycleResource::getUrl('index');
    }

    protected function getTermsUrl(): string
    {
        return TermResource::getUrl('index');
    }

    protected function getProgramsUrl(): string
    {
        return ProgramResource::getUrl('index');
    }
}
