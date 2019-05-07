<?php

namespace App\Modules\Blocks;

use App\Modules\Blocks\Http\Controllers\Admin\BlocksController;
use Charlotte\Administration\Interfaces\Structure;
use Illuminate\Support\Facades\Route;

class Administration implements Structure {

    public function dashboard()
    {

    }

    public function routes()
    {
        Route::resource('blocks',BlocksController::class);
    }

    public function menu($menu)
    {
        $menu->add(trans('blocks::admin.module_name'), ['icon' => 'fa-file-text-o']);

        $menu->get('blocks')->add(trans('administration::admin.add'), ['url' => \Charlotte\Administration\Helpers\Administration::route('blocks.create') ,'icon' => 'ti-plus']);
        $menu->get('blocks')->add(trans('administration::admin.view_all'), ['url' => \Charlotte\Administration\Helpers\Administration::route('blocks.index'), 'icon' => 'ti-list']);
    }

    public function settings($model, $form, $form_model)
    {

    }
}
