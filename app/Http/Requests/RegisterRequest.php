<?php

namespace App\Http\Requests;

class RegisterRequest extends Request
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
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'nullable|email|max:255|unique:users',
            'phone' => 'nullable|max:30|phone:countries|unique:users',
            'countries' => 'required_with:phone',
            'password' => 'required|min:6',
            'tos' => 'accepted',
        ];
    }
}
