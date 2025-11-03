<?php

namespace App\Providers;

use App\MyVendor\MyActivityLogger;
use App\MyVendor\MyPendingActivityLog;
use Illuminate\Support\ServiceProvider;
use Spatie\Activitylog\ActivityLogger;
use Spatie\Activitylog\PendingActivityLog;

class ActivityLogServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Bind our custom ActivityLogger
        $this->app->bind(ActivityLogger::class, MyActivityLogger::class);

        // Bind our custom PendingActivityLog
        $this->app->bind(PendingActivityLog::class, MyPendingActivityLog::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
