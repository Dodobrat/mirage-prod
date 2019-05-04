<?php

namespace App\Modules\Workflow\Forms;

use Kris\LaravelFormBuilder\Form;

class WorkflowForm extends Form {

    public function buildForm() {
        $this->add('title', 'text', [
            'title' => trans('administration::admin.title'),
            'translate' => true,
            'model' => @$this->model
        ]);

        $this->add('slug', 'text', [
            'title' => trans('administration::admin.slug'),
            'translate' => true,
            'model' => @$this->model
        ]);

        $this->add('access_key', 'text', [
            'title' => trans('workflow::admin.access_key'),
        ]);

        $this->add('active', 'switch', [
            'title' => trans('administration::admin.active')
        ]);

        $this->add('submit', 'button', [
            'title' => trans('types::admin.submit')
        ]);
    }
}
