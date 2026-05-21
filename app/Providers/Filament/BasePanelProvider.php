<?php

namespace App\Providers\Filament;

use App\Models\School;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Enums\Width;

abstract class BasePanelProvider extends PanelProvider
{
    protected function configurePanel(Panel $panel): Panel
    {
        return $panel
            ->tenantDomain('{tenant}.schoolerp.test')
            ->tenant(School::class, slugAttribute: 'slug')
            ->tenantRegistration(\App\MyFilament\RegisterSchool::class)
            ->maxContentWidth(Width::Full);
    }
}
