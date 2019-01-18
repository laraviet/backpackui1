<?php

namespace Laraviet\BackpackUI1;

use Illuminate\Support\ServiceProvider;

class BackpackUI1ServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'backpackui1');
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['backpackui1'];
    }
}
