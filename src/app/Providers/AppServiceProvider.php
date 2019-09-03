<?php

namespace Rocklegend\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Publish the migrations
        $this->publishes([
            realpath(__DIR__.'/vendor/catalyst/sentry/src/migrations/') => $this->app->databasePath().'/migrations',
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        
    }
}
