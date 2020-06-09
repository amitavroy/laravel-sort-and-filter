<?php

namespace Amitav\SortAndFilter;

use Illuminate\Support\ServiceProvider;

class SortAndFilterServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/sort-and-filter.php' => config_path('sort-and-filter.php'),
            ], 'config');
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/sort-and-filter.php', 'sort-and-filter');
    }
}
