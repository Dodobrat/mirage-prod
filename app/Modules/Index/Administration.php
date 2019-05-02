<?php

namespace App\Modules\Index;

use Charlotte\Administration\Interfaces\Structure;

class Administration implements Structure {

    public function dashboard()
    {

    }

    public function routes()
    {

    }

    public function menu($menu)
    {

    }

    public function settings($model, $form, $form_model)
    {
        $form->add('pageloader', 'file', [
            'title' => trans('index::admin.loader'),
        ]);

        $form->add('index_bg', 'file', [
            'title' => trans('index::admin.bg'),
        ]);

        $form->add('index_grid', 'file', [
            'title' => trans('index::admin.grid'),
        ]);
    }
}
