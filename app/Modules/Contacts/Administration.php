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
        $form->add('fb_link', 'text', [
            'title' => trans('contacts::admin.fb'),
        ]);

        $form->add('ig_link', 'text', [
            'title' => trans('contacts::admin.ig'),
        ]);

        $form->add('pi_link', 'text', [
            'title' => trans('contacts::admin.pi'),
        ]);

        $form->add('li_link', 'text', [
            'title' => trans('contacts::admin.li'),
        ]);
    }
}
