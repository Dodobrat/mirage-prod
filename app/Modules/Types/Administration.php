<?php

namespace App\Modules\Types;

use App\Modules\Types\Http\Controllers\Admin\TypesController;
use App\Modules\Types\Models\Type;
use Charlotte\Administration\Helpers\Dashboard;
use Charlotte\Administration\Interfaces\Structure;
use Illuminate\Support\Facades\Route;

class Administration implements Structure {

    public function dashboard()
    {

        $dashboard = new Dashboard();

        $dashboard->linkBox(trans('types::admin.module_name'), Type::count() , \Charlotte\Administration\Helpers\Administration::route('types.index'), 'ti-bookmark-alt', 'text-danger','col-lg-3 col-md-6 col-sm-12');

        return $dashboard->generate();

    }

    public function routes()
    {
        Route::resource('types',TypesController::class);
    }

    public function menu($menu)
    {
        $menu->add(trans('types::admin.module_name'), ['icon' => 'ti-bookmark-alt']);

        $menu->get('types')->add(trans('administration::admin.view_all'), ['url' => \Charlotte\Administration\Helpers\Administration::route('types.index')]);
        $menu->get('types')->add(trans('administration::admin.add'), ['url' => \Charlotte\Administration\Helpers\Administration::route('types.create')]);
    }

    public function settings($model, $form, $form_model)
    {
        // TODO: Implement settings() method.
    }
}
