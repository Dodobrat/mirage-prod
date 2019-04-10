<?php

namespace App\Modules\Types\Http\Requests;

use App\Modules\Types\Models\TypeTranslation;
use Illuminate\Foundation\Http\FormRequest;

class StoreTypeRequest extends FormRequest
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
            $trans[$locale . '.meta_title'] = 'nullable|string';
            $trans[$locale . '.meta_description'] = 'nullable|string';
            $trans[$locale . '.meta_keywords'] = 'nullable|string';

            if ($this->method() == 'PATCH' || $this->method() == 'PUT') {
                $locale_alb = TypeTranslation::where('type_id', $this->route('types'))->where('locale', $locale)->first();
                if($this->has($locale.'.title') && !empty($locale_alb)) {
                    $trans[$locale . '.slug'] = 'nullable|string|unique:types_translations,slug,' . $locale_alb->id;
                }
            }else{
                $trans[$locale.'.slug'] = 'nullable|string|unique:types_translations,slug';
            }
        }

        $trans['active'] = 'boolean';

        return $trans;
    }
}
