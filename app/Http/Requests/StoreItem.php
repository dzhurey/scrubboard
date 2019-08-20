<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use App\Item;

class StoreItem extends FormRequest
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
            'item_type' => 'required|in:'.join(array_keys(Item::ITEM_TYPES), ','),
            'description' => 'required',
            'price' => 'nullable|numeric',
            'item_sub_category_id' => '',
        ];
    }
}
