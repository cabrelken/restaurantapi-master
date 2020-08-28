<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaginateFormRequest extends FormRequest
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
            'page' => 'integer|min:1', 
            'perPage' => 'integer|min:1',
            'orderBy' => 'string',
            'orderDirection' => 'string',
            'search' => 'string',
            'withPaginate' => 'integer|min:0|max:1',
            'timeClean' => 'regex:/^[0-9]+$/',
        ];
    }
}
