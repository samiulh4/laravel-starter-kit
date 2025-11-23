<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        foreach (glob(base_path('app/Modules/*')) as $module) {

            $moduleName = basename($module);
            $viewPath = realpath($module . '/resources/views');

            // Load Views
            if ($viewPath && is_dir($viewPath)) {
                $this->loadViewsFrom($viewPath, $moduleName);
            }

            // Load Migrations
            $migrationPath = realpath($module . '/database/migrations');
            if ($migrationPath && is_dir($migrationPath)) {
                $this->loadMigrationsFrom($migrationPath);
            }
        }
    }
}
