<?php

namespace App\Modules\Categories\Forms;

use Kris\LaravelFormBuilder\Form;

class CategoryForm extends Form {

    public function buildForm() {
        $this->add('title', 'text', [
            'title' => trans('administration::admin.title'),
            'translate' => true,
            'model' => @$this->model
        ]);

        $this->add('active', 'switch', [
            'title' => trans('administration::admin.active')
        ]);

        $this->add('submit', 'button', [
            'title' => trans('categories::admin.submit')
        ]);
    }

}
