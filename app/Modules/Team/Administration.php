<?php

namespace App\Modules\Team;

use App\Modules\Team\Http\Controllers\Admin\TeamController;
use App\Modules\Team\Models\Member;
use Charlotte\Administration\Helpers\Dashboard;
use Charlotte\Administration\Interfaces\Structure;
use Illuminate\Support\Facades\Route;

class Administration implements Structure {

    public function dashboard()
    {

        $dashboard = new Dashboard();

        $dashboard->linkBox(trans('team::admin.module_name'), Member::count() , \Charlotte\Administration\Helpers\Administration::route('team.index'), 'ti-user', 'text-danger','col-lg-3 col-md-6 col-sm-12');

        return $dashboard->generate();

    }

    public function routes()
    {
        Route::resource('team',TeamController::class);
    }

    public function menu($menu)
    {
        $menu->add(trans('team::admin.module_name'), ['icon' => 'ti-user']);

        $menu->get('team')->add(trans('administration::admin.add'), ['url' => \Charlotte\Administration\Helpers\Administration::route('team.create') ,'icon' => 'ti-plus']);
        $menu->get('team')->add(trans('administration::admin.view_all'), ['url' => \Charlotte\Administration\Helpers\Administration::route('team.index'), 'icon' => 'ti-list']);
    }

    public function settings($model, $form, $form_model)
    {
        // TODO: Implement settings() method.
    }
}
