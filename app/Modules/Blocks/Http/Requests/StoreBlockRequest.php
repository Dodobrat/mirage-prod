<?php

namespace App\Modules\Blocks\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlockRequest extends FormRequest
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
            $trans[$locale . '.description'] = 'nullable|string';
        }

        $trans['key'] = 'required|string';
        $trans['active'] = 'boolean';

        return $trans;
    }
}
