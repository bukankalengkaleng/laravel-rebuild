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
                Rebuild::class
            ]);
        }
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
