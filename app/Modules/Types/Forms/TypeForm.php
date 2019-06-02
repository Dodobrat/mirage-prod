<?php

namespace App\Modules\Types\Forms;

use App\Modules\Categories\Models\Category;
use Charlotte\Administration\Helpers\AdministrationSeo;
use Kris\LaravelFormBuilder\Form;

class TypeForm extends Form {

    public function buildForm() {
        $this->add('title', 'text', [
            'title' => trans('administration::admin.title'),
            'translate' => true,
            'model' => @$this->model
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
            'title' => trans('types::admin.submit')
        ]);
    }
}
