<?php

namespace App\Modules\Index\Forms;

use Kris\LaravelFormBuilder\Form;

class IndexForm extends Form
{
    public function buildForm()
    {
        $this->add('title', 'text', [
            'title' => trans('administration::admin.title')
        ]);

        $this->add('active', 'switch', [
            'title' => trans('administration::admin.active')
        ]);

        $this->add('submit', 'button', [
            'title' => trans('administration::admin.submit')
        ]);

    }
}
