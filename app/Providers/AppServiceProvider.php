<?php

namespace App\Providers;

use App\Http\services\TempURLServices;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // register TempURLFacade
        $this->app->singleton('tempurl', function () {
            return new TempURLServices();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
