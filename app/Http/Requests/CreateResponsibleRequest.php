<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateResponsibleRequest extends FormRequest
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
            'name' => 'required', 
            'email' => 'required|email', 
            'password' => 'required', 
            'c_password' => 'required|same:password', 
             'role' => 'integer|min:0|max:1', 
        ];

    }
    
    public function messages()
    {
        return [
            'name.required' => 'responsible:name:required',
            'email.required' => 'responsible:email:required',
            'email.email' => 'responsible:email:email',
            'password.required' => 'responsible:password:required',
            'role.integer' => 'responsible:role:integer',
            'role.min' => 'responsible:role:min:0',
            'role.max' => 'responsible:role:max:1',
        ];
    }
}
