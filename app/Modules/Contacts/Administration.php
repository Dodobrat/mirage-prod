<?php

namespace App\Modules\Contacts;

use App\Modules\Contacts\Http\Controllers\Admin\ContactsController;
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

        $menu->get('contacts')->add(trans('administration::admin.view_all'), ['url' => \Charlotte\Administration\Helpers\Administration::route('contacts.index')]);
        $menu->get('contacts')->add(trans('administration::admin.add'), ['url' => \Charlotte\Administration\Helpers\Administration::route('contacts.create')]);
    }

    public function settings($model, $form, $form_model)
    {
        $form->add('global_email', 'text', [
            'title' => trans('contacts::admin.global_email'),
        ]);

        $form->add('global_phone', 'text', [
            'title' => trans('contacts::admin.global_phone'),
        ]);

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
