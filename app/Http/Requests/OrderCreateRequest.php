<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderCreateRequest extends FormRequest
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
            'dishes'=>'required',
            'dishes.*.amount' => 'required|integer|min:1', 
            'dishes.*.dish_id' => 'required|integer|distinct|min:1', 
        ];
    }

    public function messages()
    {
        return [
            'amount.required' => 'order:amount:required',
            'amount.integer' => 'order:amount:integer',
            'amount.min:1' => 'order:amount:min',
            'dish_id.required' => 'order:dish_id:required',
            'dish_id.integer' => 'order:dish_id:integer',
            'dish_id.min:1' => 'order:dish_id:min',
        ];
    }
}
