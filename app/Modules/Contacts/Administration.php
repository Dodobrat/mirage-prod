<?php

namespace App\Modules\Contacts;

use App\Modules\Contacts\Http\Controllers\Admin\ContactsController;
use App\Modules\Contacts\Models\Contact;
use Charlotte\Administration\Helpers\Dashboard;
use Charlotte\Administration\Interfaces\Structure;
use Illuminate\Support\Facades\Route;

class Administration implements Structure {

    public function dashboard()
    {
        $dashboard = new Dashboard();

        $dashboard->linkBox(trans('contacts::admin.module_name'), Contact::count() , \Charlotte\Administration\Helpers\Administration::route('contacts.index'), 'ti-email', 'text-danger','col-lg-3 col-md-6 col-sm-12');

        return $dashboard->generate();
    }

    public function routes()
    {
        Route::resource('contacts',ContactsController::class);
    }

    public function menu($menu)
    {
        $menu->add(trans('contacts::admin.module_name'), ['icon' => 'ti-email']);

        $menu->get('contacts')->add(trans('administration::admin.add'), ['url' => \Charlotte\Administration\Helpers\Administration::route('contacts.create') ,'icon' => 'ti-plus']);
        $menu->get('contacts')->add(trans('administration::admin.view_all'), ['url' => \Charlotte\Administration\Helpers\Administration::route('contacts.index'), 'icon' => 'ti-list']);
    }

    public function settings($model, $form, $form_model)
    {
        // TODO: Implement settings() method.
    }
}