<?php

namespace App\Modules\Categories\Http\Requests;

use App\Modules\Categories\Models\CategoryTranslation;
use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $locales = config('translatable.locales');

        $trans = [];

        foreach ($locales as $locale) {
            $trans[$locale . '.title'] = 'required|string';

            if ($this->method() == 'PATCH' || $this->method() == 'PUT') {
                $locale_alb = CategoryTranslation::where('category_id', $this->route('categories'))->where('locale', $locale)->first();
                if($this->has($locale.'.title') && !empty($locale_alb)) {
                    $trans[$locale . '.slug'] = 'nullable|string|unique:categories_translations,slug,' . $locale_alb->id;
                }
            }else{
                $trans[$locale.'.slug'] = 'nullable|string|unique:categories_translations,slug';
            }
        }

        $trans['active'] = 'boolean';

        return $trans;
    }
}
