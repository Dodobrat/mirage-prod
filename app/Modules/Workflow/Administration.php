<?php

namespace App\Modules\Workflow;

use App\Modules\Workflow\Http\Controllers\Admin\WorkflowController;
use Charlotte\Administration\Helpers\Dashboard;
use Charlotte\Administration\Interfaces\Structure;
use Illuminate\Support\Facades\Route;

class Administration implements Structure {

    public function dashboard()
    {

    }

    public function routes()
    {
        Route::resource('workflow',WorkflowController::class);
    }

    public function menu($menu)
    {
        $menu->add(trans('workflow::admin.module_name'), ['icon' => 'ti-briefcase']);

        $menu->get('workflow')->add(trans('administration::admin.add'), ['url' => \Charlotte\Administration\Helpers\Administration::route('workflow.create') ,'icon' => 'ti-plus']);
        $menu->get('workflow')->add(trans('administration::admin.view_all'), ['url' => \Charlotte\Administration\Helpers\Administration::route('workflow.index'), 'icon' => 'ti-list']);
    }

    public function settings($model, $form, $form_model)
    {
        // TODO: Implement settings() method.
    }
}
