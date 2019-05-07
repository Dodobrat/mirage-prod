<?php

namespace App\Modules\Blocks\Forms;

use Kris\LaravelFormBuilder\Form;

class BlockForm extends Form
{
    public function buildForm()
    {
        $this->add('key', 'text', [
            'title' => trans('blocks::admin.key')
        ]);

        $this->add('description', 'editor', [
            'title' => trans('blocks::admin.description'),
            'translate' => true,
            'model' => @$this->model
        ]);

        $this->add('active', 'switch', [
            'title' => trans('administration::admin.active')
        ]);

        $this->add('submit', 'button', [
            'title' => trans('blocks::admin.submit')
        ]);

    }
}
