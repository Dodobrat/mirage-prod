<?php

namespace App\Modules\Workflow\Forms;

use Charlotte\Administration\Forms\AdminForm;

class WorkflowForm extends AdminForm {

    public function buildForm() {
        $this->add('title', 'text', [
            'title' => trans('administration::admin.title'),
            'translate' => true,
            'clone' => [
                'slug'
            ]
        ]);

        $this->add('slug', 'text', [
            'title' => trans('administration::admin.slug'),
            'translate' => true
        ]);

        $this->add('access_key', 'text', [
            'title' => trans('workflow::admin.access_key'),
        ]);

        $this->add('active', 'switch', [
            'title' => trans('administration::admin.active')
        ]);

        $this->add('submit', 'button', [
            'title' => trans('administration::admin.submit')
        ]);
    }
}
