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
     *
     * input json
     * {
     *   "name": "xxx",
     *   "price_lines": [
     *     {
     *       "price_id": price_id(if exist/update),
     *       "item_id": item_id,
     *       "amount": 238293
     *     }, {
     *       "price_id": price_id(if exist/update),
     *       "item_id": item_id,
     *       "amount": 238293
     *     }
     *   ]
     * }
     */
    public function rules()
    {
        $rules = [
            'name' => 'required|max:255',
            'price_lines' => 'sometimes|required',
        ];

        if(!empty($this->request->get('price_lines'))) {
            foreach($this->request->get('price_lines') as $key => $val)
            {
                $rules['price_lines.'.$key.'.item_id'] = 'required';
                $rules['price_lines.'.$key.'.amount'] = 'required|numeric';
            }
        }

        return $rules;
    }
}
