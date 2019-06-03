<?php

namespace App\Modules\Types\Forms;

use App\Modules\Categories\Models\Category;
use Charlotte\Administration\Forms\AdminForm;
use Charlotte\Administration\Helpers\AdministrationSeo;

class TypeForm extends AdminForm {

    public function buildForm() {
        $this->add('title', 'text', [
            'title' => trans('administration::admin.title'),
            'translate' => true,
            'clone' => [
                'slug','meta_title'
            ]
        ]);

        $categories = Category::get()->pluck('title', 'id')->toArray();

        $this->add('categories', 'multiple', [
            'title' => trans('types::admin.categories'),
            'choices' => $categories,
            'value' => (!empty($this->model) && !empty($this->model->categories)) ? $this->model->categories->pluck('id')->toArray() : null,
        ]);

        AdministrationSeo::seoFields($this, $this->model);

        $this->add('active', 'switch', [
            'title' => trans('administration::admin.active')
        ]);

        $this->add('submit', 'button', [
            'title' => trans('administration::admin.submit')
        ]);
    }
}
