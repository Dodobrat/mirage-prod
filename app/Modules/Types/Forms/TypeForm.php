<?php

namespace App\Modules\Types\Forms;

use Charlotte\Administration\Helpers\AdministrationSeo;
use Kris\LaravelFormBuilder\Form;

class TypeForm extends Form {

    public function buildForm() {
        $this->add('title', 'text', [
            'title' => trans('administration::admin.title'),
            'translate' => true,
            'model' => @$this->model
        ]);

        AdministrationSeo::seoFields($this, $this->model);

        $this->add('active', 'switch', [
            'title' => trans('administration::admin.active')
        ]);

        $this->add('submit', 'button', [
            'title' => trans('types::admin.submit')
        ]);
    }
}
