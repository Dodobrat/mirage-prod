<?php

namespace App\Modules\Types\Forms;

use App\Modules\Filters\Models\Filter;
use Charlotte\Administration\Helpers\AdministrationSeo;
use Kris\LaravelFormBuilder\Form;

class TypeForm extends Form {

    public function buildForm() {
        $this->add('title', 'text', [
            'title' => trans('administration::admin.title'),
            'translate' => true,
            'model' => @$this->model
        ]);

        $filters = Filter::all()->pluck('title','id')->toArray();

        $this->add('filters', 'select', [
            'title' => trans('types::admin.filters'),
            'choices' => $filters,
            'selected' => (!empty($this->model) && !empty($this->model->filters)) ? $this->model->filters->pluck('id')->toArray() : null,
            'helper_box' => trans('types::admin.choose_filters'),
        ]);

//        $this->add('meta_title', 'text',[
//            'title' => trans('administration::admin.title'),
//            'translate' => true,
//            'model' => @$this->model,
//        ]);

//        AdministrationSeo::seoFields($this, $this->model);

        $this->add('active', 'switch', [
            'title' => trans('administration::admin.active'),
        ]);

        $this->add('submit', 'button', [
            'title' => trans('administration::admin.submit')
        ]);
    }
}
