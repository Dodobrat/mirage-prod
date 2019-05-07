<?php

namespace App\Modules\Blocks\Providers;

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
        $this->loadTranslationsFrom(module_path('blocks', 'Resources/Lang', 'app'), 'blocks');
        $this->loadViewsFrom(module_path('blocks', 'Resources/Views', 'app'), 'blocks');
        $this->loadMigrationsFrom(module_path('blocks', 'Database/Migrations', 'app'), 'blocks');
        $this->loadConfigsFrom(module_path('blocks', 'Config', 'app'));
        $this->loadFactoriesFrom(module_path('blocks', 'Database/Factories', 'app'));
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
