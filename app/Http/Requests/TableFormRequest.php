<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TableFormRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [     
            'name' => 'required', 
       ];
    }

    
    public function messages()
    {
        return [
            'name.required' => 'table:name:required',
        ];
    }
}
