<?php

namespace App\Modules\Contacts\Http\Requests;

use App\Modules\Contacts\Models\ContactTranslation;
use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
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
            $trans[$locale . '.description'] = 'nullable|string';
            $trans[$locale . '.working_time'] = 'nullable|string';
            $trans[$locale . '.email'] = 'nullable|email';
            $trans[$locale . '.address'] = 'nullable|string';
            $trans[$locale . '.phone'] = 'nullable|string';
            $trans[$locale . '.meta_title'] = 'nullable|string';
            $trans[$locale . '.meta_description'] = 'nullable|string';
            $trans[$locale . '.meta_keywords'] = 'nullable|string';

            if ($this->method() == 'PATCH' || $this->method() == 'PUT') {
                $locale_alb = ContactTranslation::where('contact_id', $this->route('contacts'))->where('locale', $locale)->first();
                if($this->has($locale.'.title') && !empty($locale_alb)) {
                    $trans[$locale . '.slug'] = 'nullable|string|unique:contacts_translations,slug,' . $locale_alb->id;
                }
            }else{
                $trans[$locale.'.slug'] = 'nullable|string|unique:contacts_translations,slug';
            }
        }

        $trans['lat'] = 'required|string';
        $trans['lng'] = 'required|string';
        $trans['show_map'] = 'boolean';
        $trans['active'] = 'boolean';

        return $trans;
    }
}
