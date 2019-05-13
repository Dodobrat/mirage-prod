<?php

namespace App\Modules\Projects;

use App\Modules\Projects\Http\Controllers\Admin\ProjectsController;
use App\Modules\Projects\Models\Project;
use Charlotte\Administration\Helpers\Dashboard;
use Charlotte\Administration\Interfaces\Structure;
use Illuminate\Support\Facades\Route;

class Administration implements Structure {

    public function dashboard()
    {

        $dashboard = new Dashboard();

        $dashboard->linkBox(trans('projects::admin.module_name'), Project::count() , \Charlotte\Administration\Helpers\Administration::route('projects.index'), 'ti-book', 'text-danger','col-lg-3 col-md-6 col-sm-12');

        return $dashboard->generate();

    }

    public function routes()
    {
        Route::resource('projects',ProjectsController::class);
    }

    public function menu($menu)
    {
        $menu->add(trans('projects::admin.module_name'), ['icon' => 'ti-book']);

        $menu->get('projects')->add(trans('administration::admin.view_all'), ['url' => \Charlotte\Administration\Helpers\Administration::route('projects.index')]);
        $menu->get('projects')->add(trans('administration::admin.add'), ['url' => \Charlotte\Administration\Helpers\Administration::route('projects.create')]);
    }

    public function settings($model, $form, $form_model)
    {
        // TODO: Implement settings() method.
    }
}
