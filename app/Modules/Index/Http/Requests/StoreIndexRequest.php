<?php

namespace App\Modules\Index\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIndexRequest extends FormRequest
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

        $trans = [];

        $trans['title'] = 'required|string';
        $trans['active'] = 'boolean';

        return $trans;
    }
}
