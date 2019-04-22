<?php

namespace App\Modules\Workflow\Providers;

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
        $this->loadTranslationsFrom(module_path('workflow', 'Resources/Lang', 'app'), 'workflow');
        $this->loadViewsFrom(module_path('workflow', 'Resources/Views', 'app'), 'workflow');
        $this->loadMigrationsFrom(module_path('workflow', 'Database/Migrations', 'app'), 'workflow');
        $this->loadConfigsFrom(module_path('workflow', 'Config', 'app'));
        $this->loadFactoriesFrom(module_path('workflow', 'Database/Factories', 'app'));
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
