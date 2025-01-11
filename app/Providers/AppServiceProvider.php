<?php

namespace App\Providers;

use Illuminate\Console\Scheduling\Event;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\Facades\Socialite;
use Spatie\Health\Checks\Checks\DebugModeCheck;
use Spatie\Health\Checks\Checks\EnvironmentCheck;
use Spatie\Health\Checks\Checks\OptimizedAppCheck;
use Spatie\Health\Facades\Health;

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
        try {
            $siteName = DB::table('general_settings')->value('site_name');
            Log::info('Site name from DB: ' . $siteName); // Debug line
            if ($siteName) {
                Config::set('app.name', $siteName);
            }
        } catch (\Exception $e) {
            Log::error('Settings error: ' . $e->getMessage());
        }
        if (file_exists(storage_path('app/public/assets/site_favicon.ico'))) {
            copy(
                storage_path('app/public/assets/site_favicon.ico'), 
                public_path('favicon.ico')
            );
        }
        Health::checks([
            OptimizedAppCheck::new(),
            DebugModeCheck::new(),
            EnvironmentCheck::new(),
        ]);
    }
}
