<?php

namespace App\Filament\It\Widgets;

use App\Filament\It\Resources\Cycles\CycleResource;
use App\Filament\It\Resources\Programs\ProgramResource;
use App\Filament\It\Resources\Terms\TermResource;
use App\Filament\Widgets\OnboardingChecklistWidget as BaseOnboardingChecklistWidget;

class OnboardingChecklistWidget extends BaseOnboardingChecklistWidget
{
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
