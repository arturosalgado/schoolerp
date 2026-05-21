<?php

namespace App\Providers\Filament;

use App\MyFilament\MyAdminLogin;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Width;
use Filament\Widgets\AccountWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class StudentsPanelProvider extends BasePanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $this->configurePanel($panel)
            ->id('students')
            ->path('students')
            ->login(MyAdminLogin::class)
            ->colors([
                'primary' => Color::Blue,
            ])
            ->discoverResources(in: app_path('Filament/Students/Resources'), for: 'App\Filament\Students\Resources')
            ->discoverPages(in: app_path('Filament/Students/Pages'), for: 'App\Filament\Students\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Students/Widgets'), for: 'App\Filament\Students\Widgets')
            ->widgets([
                AccountWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
