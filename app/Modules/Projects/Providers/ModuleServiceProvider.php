<?php

namespace App\Modules\Projects\Providers;

use Caffeinated\Modules\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the module services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(module_path('projects', 'Resources/Lang', 'app'), 'projects');
        $this->loadViewsFrom(module_path('projects', 'Resources/Views', 'app'), 'projects');
        $this->loadMigrationsFrom(module_path('projects', 'Database/Migrations', 'app'), 'projects');
        $this->loadConfigsFrom(module_path('projects', 'Config', 'app'));
        $this->loadFactoriesFrom(module_path('projects', 'Database/Factories', 'app'));
    }

    /**
     * Register the module services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }
}
