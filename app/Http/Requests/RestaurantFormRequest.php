<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RestaurantFormRequest extends FormRequest
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

    
   public function rules()
    {
        return [
            'name' => 'required', 
            'email' => 'required|email', 
         ];
    }

    public function messages()
    {
        return [
            'email.required' => 'restaurant:email:required ',
            'email.email' => 'restaurant:email:email',
            'name.required' => 'restaurant:name:required',
         ];
    }
}
