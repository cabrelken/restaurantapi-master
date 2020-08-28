<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DishIdsRequest extends FormRequest
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
            'dishes' => 'required',
            'dishes.*.dish_id' => 'required|integer|distinct|min:1'
        ];
    }

    public function messages()
    {
        return [
            'dishes.required' => 'dishes:required',
            'dishes.dish_id.required' => 'dish:dish_id:required',
            'dishes.dish_id.integer' => 'dish:dish_id:integer',
            'dishes.dish_id.distinct' => 'dish:dish_id:distinct',
            'dishes.dish_id.min:1' => 'dish:dish_id:positive',
        ];
    }
}
