<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use App\Item;
use App\Price;
use App\ItemGroup;
use App\ItemSubCategory;

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
     *
     * {
     *     "item_type": "service",
     *     "description": "Item B",
     *     "price": 70000,
     *     "price_id": 17,
     *     "item_group_id": 1,
     *     "item_sub_category_id": 1
     * }
     */
    public function rules()
    {
        return [
            'item_type' => 'required|in:'.join(array_keys(Item::ITEM_TYPES), ','),
            'description' => 'required',
            'price' => 'required|numeric',
            'price_id' => 'required',
            'item_group_id' => 'required',
            'item_sub_category_id' => 'required',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->priceIsNotFound()) {
                $validator->errors()->add('price_id', __('rules.data_not_found'));
            }

            if ($this->itemGroupIsNotFound()) {
                $validator->errors()->add('item_group_id', __('rules.data_not_found'));
            }

            if ($this->itemSubCategoryIsNotFound()) {
                $validator->errors()->add('item_sub_category_id', __('rules.data_not_found'));
            }
        });
    }

    private function priceIsNotFound()
    {
        $item = Price::find($this->request->get('price_id'));

        if (empty($item)) {
            return true;
        }

        return false;
    }

    private function itemGroupIsNotFound()
    {
        $item = ItemGroup::find($this->request->get('item_group_id'));

        if (empty($item)) {
            return true;
        }

        return false;
    }

    private function itemSubCategoryIsNotFound()
    {
        $item = ItemSubCategory::find($this->request->get('item_sub_category_id'));

        if (empty($item)) {
            return true;
        }

        return false;
    }
}
