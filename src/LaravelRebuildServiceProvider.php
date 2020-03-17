<?php

namespace BukanKalengKaleng\LaravelRebuild;

use Illuminate\Support\ServiceProvider;
use BukanKalengKaleng\LaravelRebuild\Console\Commands\Rebuild;

class LaravelRebuildServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Rebuild::class,
            ]);
        }

        $this->publishes([
            __DIR__.'/../config/rebuild.php' => config_path('rebuild.php'),
        ], 'laravel-rebuild');

        $this->mergeConfigFrom(__DIR__.'/../config/rebuild.php', 'rebuild');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
