<?php

namespace App\Modules\Filters\Forms;

use Kris\LaravelFormBuilder\Form;

class FilterForm extends Form {

    public function buildForm() {
        $this->add('title', 'text', [
            'title' => trans('administration::admin.title'),
            'translate' => true,
            'model' => @$this->model
        ]);

        $this->add('active', 'switch', [
            'title' => trans('administration::admin.active'),
        ]);

        $this->add('submit', 'button', [
            'title' => trans('administration::admin.submit')
        ]);
    }

}
