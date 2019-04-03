<?php

namespace App\Modules\Types;

use App\Modules\Types\Http\Controllers\Admin\TypesController;
use Charlotte\Administration\Interfaces\Structure;
use Illuminate\Support\Facades\Route;

class Administration implements Structure {

    public function dashboard()
    {
        // TODO: Implement dashboard() method.
    }

    public function routes()
    {
        Route::resource('types', TypesController::class);
    }

    public function menu($menu)
    {
        $menu->add(trans('types::admin.module_name'), ['icon' => 'ti-comments']);

        $menu->get('types')
            ->add(trans('administration::admin.add'), ['url' => \Charlotte\Administration\Helpers\Administration::route('types.create') ,'icon' => 'ti-plus']);
        $menu->get('types')
            ->add(trans('administration::admin.view_all'), ['url' => \Charlotte\Administration\Helpers\Administration::route('types.index'), 'icon' => 'ti-list']);
    }
}
