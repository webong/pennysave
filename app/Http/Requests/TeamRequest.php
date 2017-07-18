<?php

namespace App\Http\Requests;

use App\Recurrence;

class TeamRequest extends Request
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
            'name' => 'required|string|unique:groups',
            'amount' => 'required|numeric|between:0,999999999999',
            'participants' => 'required|integer|max:50',
            'recurrence' => 'required|integer|between:1,4',
            'start_date' => 'required|date|after:yesterday',
        ];
    }
}
