<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InviteSinglyRequest extends FormRequest
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
            'first_name.*' => 'nullable|string',
            'email.*' => 'nullable|email|max:255|required_if:phone.*,null',
            'phone.*' => 'nullable|phone:countries|required_if:email.*,null',
            'countries.*' => 'required_with:phone',
            'message' => 'nullable|string|max:140',
        ];
    }
}
