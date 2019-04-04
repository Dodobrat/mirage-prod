<?php
namespace App\Modules\Filters;

use App\Modules\Filters\Http\Controllers\Admin\FiltersController;
use Charlotte\Administration\Interfaces\Structure;
use Illuminate\Support\Facades\Route;

class Administration implements Structure {

    public function dashboard()
    {
        // TODO: Implement dashboard() method.
    }

    public function routes()
    {
        Route::resource('filters', FiltersController::class);
    }

    public function menu($menu)
    {
        $menu->add(trans('filters::admin.module_name'), ['icon' => 'ti-comments']);

        $menu->get('filters')
            ->add(trans('administration::admin.add'), ['url' => \Charlotte\Administration\Helpers\Administration::route('filters.create') ,'icon' => 'ti-plus']);
        $menu->get('filters')
            ->add(trans('administration::admin.view_all'), ['url' => \Charlotte\Administration\Helpers\Administration::route('filters.index'), 'icon' => 'ti-list']);
    }
}
