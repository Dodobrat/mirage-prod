<?php

namespace App\Modules\Team\Forms;

use Kris\LaravelFormBuilder\Form;

class MemberForm extends Form {

    public function buildForm() {
        $this->add('name', 'text', [
            'title' => trans('team::admin.name'),
            'translate' => true,
            'model' => @$this->model
        ]);

        $this->add('position', 'text', [
            'title' => trans('team::admin.position'),
            'translate' => true,
            'model' => @$this->model
        ]);

        $this->add('active', 'switch', [
            'title' => trans('administration::admin.active')
        ]);

        $this->add('submit', 'button', [
            'title' => trans('team::admin.submit')
        ]);
    }
}
