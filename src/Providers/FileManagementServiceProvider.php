<?php

namespace GoApptiv\FileManagement\Providers;

use GoApptiv\FileManagement\Services\FileManagement\FileManagementService;
use Illuminate\Support\ServiceProvider;

class FileManagementServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Publishes the migration files
        $this->publishes([
            __DIR__ . '/../../database/migrations/' => database_path('migrations'),
        ], 'file-management-migrations');

        if ($this->app->runningInConsole()) {
            $this->commands([]);
        }
    }

    public function register()
    {
        $this->app->singleton('goapptiv-file-management', function ($app) {
            return new FileManagementService();
        });
    }
}
