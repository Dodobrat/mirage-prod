<?php

namespace App\Modules\Filters\Providers;

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
        $this->loadTranslationsFrom(module_path('filters', 'Resources/Lang', 'app'), 'filters');
        $this->loadViewsFrom(module_path('filters', 'Resources/Views', 'app'), 'filters');
        $this->loadMigrationsFrom(module_path('filters', 'Database/Migrations', 'app'), 'filters');
        $this->loadConfigsFrom(module_path('filters', 'Config', 'app'));
        $this->loadFactoriesFrom(module_path('filters', 'Database/Factories', 'app'));
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
