<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

    
    public function rules()
    {
        return [
            'email' => 'required|email', 
            'password' => 'required',
            'table_id' => 'integer|min:1', 
        ];
    }

    
    public function messages()
    {
        return [
            'email.required' => 'responsible:email:required',
            'email.email' => 'responsible:email:email',
            'password.required' => 'responsible:password:required',
            'table_id.integer' => 'responsible:table_id:integer',
            'table_id.min' => 'responsible:table_id:Min',
        ];
    }
}
