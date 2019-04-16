<?php

namespace App\Modules\Team\Providers;

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
        $this->loadTranslationsFrom(module_path('team', 'Resources/Lang', 'app'), 'team');
        $this->loadViewsFrom(module_path('team', 'Resources/Views', 'app'), 'team');
        $this->loadMigrationsFrom(module_path('team', 'Database/Migrations', 'app'), 'team');
        $this->loadConfigsFrom(module_path('team', 'Config', 'app'));
        $this->loadFactoriesFrom(module_path('team', 'Database/Factories', 'app'));
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
