<?php

namespace App\Modules\Projects\Forms;

use App\Modules\Categories\Models\Category;
use Charlotte\Administration\Forms\AdminForm;

class ProjectForm extends AdminForm {

    public function buildForm() {
        $this->add('title', 'text', [
            'title' => trans('administration::admin.title'),
            'translate' => true
        ]);

        $this->add('architect', 'text', [
            'title' => trans('projects::admin.architect'),
            'translate' => true
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
            'title' => trans('administration::admin.submit')
        ]);
    }

}
