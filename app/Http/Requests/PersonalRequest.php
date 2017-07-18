<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PersonalRequest extends FormRequest
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
        return [
            'name' => 'required|string|max:50',
            'target_amount' => 'required|numeric|between:0,999999999999',
            'instalment_amount' => 'required|numeric|between:0,999999999999',
            'recurrence' => 'required|integer|between:1,4',
            'priority' => 'integer|between:1,4',
            'start_date' => 'required|date|after:yesterday',
            'target_date' => 'required|date|after:yesterday',
        ];
    }
}
