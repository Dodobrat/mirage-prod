<?php

namespace App\Modules\Categories\Forms;

use Charlotte\Administration\Forms\AdminForm;

class CategoryForm extends AdminForm {

    public function buildForm() {
        $this->add('title', 'text', [
            'title' => trans('administration::admin.title'),
            'translate' => true
        ]);

        $this->add('active', 'switch', [
            'title' => trans('administration::admin.active')
        ]);

        $this->add('submit', 'button', [
            'title' => trans('administration::admin.submit')
        ]);
    }

}
