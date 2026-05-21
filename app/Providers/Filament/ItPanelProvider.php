<?php

namespace App\Providers\Filament;

use App\MyFilament\MyAccountWidget;
use App\MyFilament\MyAdminLogin;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Width;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class ItPanelProvider extends BasePanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $this->configurePanel($panel)
            ->id('it')
            ->path('information-technology')
            ->login(MyAdminLogin::class)
            ->passwordReset()
            ->databaseNotifications()
            ->maxContentWidth(Width::Full)
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/It/Resources'), for: 'App\Filament\It\Resources')
            ->discoverPages(in: app_path('Filament/It/Pages'), for: 'App\Filament\It\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/It/Widgets'), for: 'App\Filament\It\Widgets')
            ->widgets([
                MyAccountWidget::class,

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
