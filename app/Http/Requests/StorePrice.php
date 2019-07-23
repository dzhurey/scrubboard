<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StorePrice extends FormRequest
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
        $rules = [
            'name' => 'required|max:255',
        ];

        foreach($this->request->get('price_lines') as $key => $val)
        {
            $rules['price_lines.'.$key.'.id'] = 'sometimes|required|numeric';
            $rules['price_lines.'.$key.'.price_id'] = 'sometimes|required|numeric';
            $rules['price_lines.'.$key.'.item_id'] = 'required';
            $rules['price_lines.'.$key.'.amount'] = 'required|numeric';
        }

        return $rules;
    }
}
