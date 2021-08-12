<?php

namespace Mawuekom\Passauth;

use Illuminate\Support\ServiceProvider;

class PassauthServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        require_once __DIR__ . '/helpers.php';

        /*
         * Optional methods to load your package assets
         */
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'passauth');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/passauth.php' => config_path('passauth.php'),
            ], 'config');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/passauth.php', 'passauth');

        // Register the main class to use with the facade
        $this->app->singleton('passauth', function () {
            return new Passauth;
        });
    }
}
