<?php

namespace App\Modules\Index;

use App\Modules\Index\Http\Controllers\Admin\IndexController;
use Charlotte\Administration\Interfaces\Structure;
use Illuminate\Support\Facades\Route;

class Administration implements Structure {

    public function dashboard()
    {

    }

    public function routes()
    {
        Route::resource('index',IndexController::class);
    }

    public function menu($menu)
    {
        $menu->add(trans('index::admin.module_name'), ['icon' => 'fa-home']);

        $menu->get('index')->add(trans('administration::admin.view_all'), ['url' => \Charlotte\Administration\Helpers\Administration::route('index.index')]);
        $menu->get('index')->add(trans('administration::admin.add'), ['url' => \Charlotte\Administration\Helpers\Administration::route('index.create')]);
    }

    public function settings($model, $form, $form_model)
    {
        $form->add('pageloader', 'file', [
            'title' => trans('index::admin.loader'),
        ]);

    }
}
