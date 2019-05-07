<?php

namespace App\Modules\Projects\Forms;

use App\Modules\Categories\Models\Category;
use Kris\LaravelFormBuilder\Form;

class ProjectForm extends Form {

    public function buildForm() {
        $this->add('title', 'text', [
            'title' => trans('administration::admin.title'),
            'translate' => true,
            'model' => @$this->model
        ]);

        $this->add('architect', 'text', [
            'title' => trans('projects::admin.architect'),
            'translate' => true,
            'model' => @$this->model
        ]);

        $categories = Category::active()->get()->pluck('title', 'id')->toArray();

        $this->add('category_id', 'select', [
            'title' => trans('projects::admin.category_id'),
            'choices' => $categories,
            'value' => @$this->model->category_id
        ]);

        $this->add('active', 'switch', [
            'title' => trans('administration::admin.active')
        ]);

        $this->add('submit', 'button', [
            'title' => trans('categories::admin.submit')
        ]);
    }

}
