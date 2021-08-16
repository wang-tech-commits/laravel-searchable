<?php

namespace MrwangTc\Searchable;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider
{
    public function boot(): void
    {
        \config('searchable.migrations') && $this->loadMigrationsFrom(__DIR__.'/../migrations');

        $this->publishes([
            __DIR__.'/../migrations' => \database_path('migrations'),
        ], 'migrations');

        $this->publishes([
            __DIR__.'/../config/searchable.php' => \config_path('searchable.php'),
        ], 'config');
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/searchable.php', 'searchable');
    }
}