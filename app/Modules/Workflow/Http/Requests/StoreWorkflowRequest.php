<?php

namespace App\Modules\Workflow\Http\Requests;

use App\Modules\Workflow\Models\WorkflowTranslation;
use Illuminate\Foundation\Http\FormRequest;

class StoreWorkflowRequest extends FormRequest
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
                $locale_alb = WorkflowTranslation::where('workflow_id', $this->route('workflow'))->where('locale', $locale)->first();
                if($this->has($locale.'.title') && !empty($locale_alb)) {
                    $trans[$locale . '.slug'] = 'nullable|string|unique:workflow_translations,slug,' . $locale_alb->id;
                }
            }else{
                $trans[$locale.'.slug'] = 'nullable|string|unique:workflow_translations,slug';
            }
        }

        $trans['access_key'] = 'required|string';
        $trans['active'] = 'boolean';

        return $trans;
    }
}
