<?php

namespace GoApptiv\FileManagement\Providers;

use GoApptiv\FileManagement\Controller\FileVariantController;
use GoApptiv\FileManagement\Repositories\FileManagement\FileManagementLogRepositoryInterface;
use GoApptiv\FileManagement\Repositories\FileManagement\FileManagementVariantLogRepositoryInterface;
use GoApptiv\FileManagement\Requests\FileVariantRequest;
use GoApptiv\FileManagement\Services\FileManagement\FileManagementService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class FileManagementServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Publishes the migration files
        $this->publishes([
            __DIR__ . '/../../database/migrations/' => database_path('migrations'),
        ], 'file-management-migrations');

        $this->loadRoutesFrom(__DIR__.'/../route/api_v1.php');

        if ($this->app->runningInConsole()) {
            $this->commands([]);
        }
    }

    public function register()
    {
        $this->app->bind(FileVariantController::class, function ($app) {
            return new FileVariantController($app->make(FileManagementService::class));
        });

        $this->app->singleton('goapptiv-file-management', function ($app) {
            return new FileManagementService(
                $app->make(
                    FileManagementLogRepositoryInterface::class
                ),
                $app->make(
                    FileManagementVariantLogRepositoryInterface::class
                )
            );
        });
    }
}
