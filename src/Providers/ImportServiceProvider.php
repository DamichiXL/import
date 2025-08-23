<?php

namespace DamichiXL\Import\Providers;

use Illuminate\Support\ServiceProvider;

class ImportServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/import.php', 'import');
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/import.php' => config_path('import.php'),
        ], 'config');

        $this->loadMigrationsFrom(__DIR__.'/../migrations');

        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        $this->loadTranslationsFrom(__DIR__.'/../lang', 'import');
    }
}
