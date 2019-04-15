<?php

namespace App\Modules\Contacts\Forms;

use Charlotte\Administration\Helpers\AdministrationSeo;
use Kris\LaravelFormBuilder\Form;

class ContactForm extends Form
{
    public function buildForm()
    {
        $this->add('title', 'text', [
            'title' => trans('administration::admin.title'),
            'translate' => true,
            'model' => @$this->model
        ]);

        $this->add('description', 'editor', [
            'title' => trans('contacts::admin.description'),
            'translate' => true,
            'model' => @$this->model
        ]);

        $this->add('working_time', 'editor', [
            'title' => trans('contacts::admin.working_time'),
            'translate' => true,
            'model' => @$this->model
        ]);

        $this->add('address', 'text', [
            'title' => trans('contacts::admin.address'),
            'translate' => true,
            'model' => @$this->model
        ]);

        $this->add('email', 'text', [
            'title' => trans('contacts::admin.email'),
            'translate' => true,
            'model' => @$this->model
        ]);

        $this->add('phone', 'text', [
            'title' => trans('contacts::admin.phone'),
            'translate' => true,
            'model' => @$this->model
        ]);


        $this->add('location', 'map', [
            'title' => trans('contacts::admin.map'),
            'default_values' => [
                'lat' => @$this->model->lat,
                'lng' => @$this->model->lng
            ]

        ]);

        AdministrationSeo::seoFields($this, $this->model);

        $this->add('active', 'switch', [
            'title' => trans('administration::admin.active')
        ]);

        $this->add('show_map', 'switch', [
            'title' => trans('contacts::admin.show_map')
        ]);

        $this->add('submit', 'button', [
            'title' => trans('types::admin.submit')
        ]);

    }
}