<?php

namespace App\Modules\Blocks\Forms;

use Charlotte\Administration\Forms\AdminForm;

class BlockForm extends AdminForm
{
    public function buildForm()
    {
        $this->add('key', 'text', [
            'title' => trans('blocks::admin.key')
        ]);

        $this->add('description', 'editor', [
            'title' => trans('administration::admin.description'),
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
