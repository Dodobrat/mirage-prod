<?php

namespace App\Modules\Categories\Providers;

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
        $this->loadTranslationsFrom(module_path('categories', 'Resources/Lang', 'app'), 'categories');
        $this->loadViewsFrom(module_path('categories', 'Resources/Views', 'app'), 'categories');
        $this->loadMigrationsFrom(module_path('categories', 'Database/Migrations', 'app'), 'categories');
        $this->loadConfigsFrom(module_path('categories', 'Config', 'app'));
        $this->loadFactoriesFrom(module_path('categories', 'Database/Factories', 'app'));
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
