<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateRestaurantRequest extends FormRequest
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
            'responsible_id' => 'required|integer|min:1', 
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'restaurant:name:required',
            'email.required' => 'restaurant:email:required',
            'email.email' => 'restaurant:email:email',
            'responsible_id.required' => 'restaurant:responsible_id:required',
            'responsible_id.integer' => 'restaurant:responsible_id:integer',
            'responsible_id.min:1' => 'restaurant:responsible_id:min:1',
        ];
    }
}
