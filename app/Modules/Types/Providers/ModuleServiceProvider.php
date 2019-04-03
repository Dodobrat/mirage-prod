<?php

namespace App\Modules\Types\Providers;

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
        $this->loadTranslationsFrom(module_path('types', 'Resources/Lang', 'app'), 'types');
        $this->loadViewsFrom(module_path('types', 'Resources/Views', 'app'), 'types');
        $this->loadMigrationsFrom(module_path('types', 'Database/Migrations', 'app'), 'types');
        $this->loadConfigsFrom(module_path('types', 'Config', 'app'));
        $this->loadFactoriesFrom(module_path('types', 'Database/Factories', 'app'));
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
