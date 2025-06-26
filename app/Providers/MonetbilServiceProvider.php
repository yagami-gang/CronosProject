<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class MonetbilServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        require_once app_path('Libraries/Monetbil/autoload.php');
    require_once app_path('Libraries/Monetbil/config.php');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
