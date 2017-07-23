<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MessageRequest extends FormRequest
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
            'receivers.*' => 'string|max:36',
            'subject' => 'string|max:70',
            'message' => 'string',
            'attachment' => 'file|mimes:jpeg,bmp,png,pdf,doc,docx,xsl,xslx,ppt,pptx',
        ];
    }
}
