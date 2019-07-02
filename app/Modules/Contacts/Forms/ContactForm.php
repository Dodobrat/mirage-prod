<?php

namespace App\Modules\Contacts\Forms;

use Charlotte\Administration\Forms\AdminForm;
use Charlotte\Administration\Helpers\AdministrationSeo;

class ContactForm extends AdminForm
{
    public function buildForm()
    {
        $this->add('title', 'text', [
            'title' => trans('administration::admin.title'),
            'translate' => true,
            'clone' => [
                'meta_title'
            ]
        ]);

        $this->add('description', 'editor', [
            'title' => trans('administration::admin.description'),
            'translate' => true
        ]);

        $this->add('working_time', 'text', [
            'title' => trans('contacts::admin.working_time'),
            'translate' => true
        ]);

        $this->add('address', 'text', [
            'title' => trans('contacts::admin.address'),
            'translate' => true
        ]);

        $this->add('email', 'text', [
            'title' => trans('contacts::admin.email'),
            'translate' => true
        ]);

        $this->add('phone', 'text', [
            'title' => trans('contacts::admin.phone'),
            'translate' => true
        ]);


        $this->add('location', 'map', [
            'default_values' => [
                'lat' => @$this->model->lat,
                'lng' => @$this->model->lng
            ]

        ]);

        AdministrationSeo::seoFields($this, [
            'meta_description' => ['live-count' => 250, 'maxlength' => '250']
        ]);

        $this->add('active', 'switch', [
            'title' => trans('administration::admin.active')
        ]);

        $this->add('show_map', 'switch', [
            'title' => trans('contacts::admin.show_map')
        ]);

        $this->add('submit', 'button', [
            'title' => trans('administration::admin.submit')
        ]);

    }
}
