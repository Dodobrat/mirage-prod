<?php

namespace App\Modules\Categories;

use App\Modules\Categories\Http\Controllers\Admin\CategoriesController;
use App\Modules\Categories\Models\Category;
use Charlotte\Administration\Interfaces\Structure;
use Illuminate\Support\Facades\Route;
use Charlotte\Administration\Helpers\Dashboard;

class Administration implements Structure {

    public function dashboard()
    {

        $dashboard = new Dashboard();

        $dashboard->linkBox(trans('categories::admin.module_name'), Category::count() , \Charlotte\Administration\Helpers\Administration::route('categories.index'), 'fa-filter', 'text-danger','col-lg-4 col-md-12 col-sm-12');

        return $dashboard->generate();

    }

    public function routes()
    {
        Route::resource('categories',CategoriesController::class);
    }

    public function menu($menu)
    {
        $menu->add(trans('categories::admin.module_name'), ['icon' => 'fa-filter']);

        $menu->get('categories')->add(trans('administration::admin.add'), ['url' => \Charlotte\Administration\Helpers\Administration::route('categories.create') ,'icon' => 'ti-plus']);
        $menu->get('categories')->add(trans('administration::admin.view_all'), ['url' => \Charlotte\Administration\Helpers\Administration::route('categories.index'), 'icon' => 'ti-list']);
    }

    public function settings($model, $form, $form_model)
    {
        // TODO: Implement settings() method.
    }
}
