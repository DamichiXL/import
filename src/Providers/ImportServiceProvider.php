<?php

namespace DamichiXL\Import\Providers;

use Illuminate\Support\ServiceProvider;

class ImportServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../../config/config.php' => config_path('import.php'),
        ], [
            'import',
            'import-config',
        ]);

        $this->publishesMigrations([
            __DIR__ . '/../../database/migrations' => database_path('migrations'),
        ], [
            'import',
            'import-migrations',
        ]);

        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');

        $this->loadTranslationsFrom(__DIR__ . '/../../lang', 'import');

        $this->publishes([
            __DIR__ . '/../../lang' => $this->app->langPath('vendor/import'),
        ], [
            'import',
            'import-translations',
        ]);
    }
}
