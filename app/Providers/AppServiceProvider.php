<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ResetPassword::createUrlUsing(function ($notifiable, string $token) {
            $roles = $notifiable->roles()->pluck('name')->toArray();

            // If the user's only role is IT, send them to the IT panel
            $panelId = (\count($roles) === 1 && $roles[0] === 'information_technology')
                ? 'it'
                : 'admin';

            return Filament::getPanel($panelId)->getResetPasswordUrl($token, $notifiable);
        });
    }
}
