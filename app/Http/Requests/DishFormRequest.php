<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DishFormRequest extends FormRequest
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
            "description" => 'required',
            "image" =>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            "price" => 'required|regex:/^\d+(\.\d{1,2})?$/',
      ];
    }

    public function messages()
    {
        return [
            'name.required' => 'dish:name:required',
            'description.required' => 'dish:description:required',
            'image.mimes' => 'dish:image:extension',
            'image.max' => 'dish:image:max',
            'price.required' => 'dish:price:required',
            'price.regex' => 'dish:price:regex',
        ];
    }
}
