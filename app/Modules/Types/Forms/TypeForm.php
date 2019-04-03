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

//        $filters = Filter::active()->pluck('title','id')->toArray();
//
//        $this->add('filters', 'select', [
//            'label' => trans('types::admin.categories'),
//            'choices' => $filters,
//            'selected' => (!empty($this->model) && !empty($this->model->categories)) ? $this->model->categories->pluck('id')->toArray() : null,
//            'attr' => [
//                'multiple' => 'multiple',
//                'class' => 'select2',
//                'id' => 'categories-exist2',
//                'style' => 'width: 100%;'
//            ],
//            'empty_value' => trans('products::admin.empty_value'),
//        ]);

//        $this->add('filters', 'multiple', [
//            'title' => trans('types::admin.filters'),
//        ]);

        AdministrationSeo::seoFields($this, $this->model);

        $this->add('active', 'switch', [
            'title' => trans('administration::admin.active'),
        ]);

        $this->add('submit', 'button', [
            'title' => trans('administration::admin.submit')
        ]);
    }
}
