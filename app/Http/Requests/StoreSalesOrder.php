<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use App\Transaction;

class StoreSalesOrder extends FormRequest
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
            'customer_id' => 'required',
            'transaction_type' => 'required|in:'.join(array_keys(Transaction::TRANSACTION_TYPES), ','),
            'order_type' => 'required|in:'.join(array_keys(Transaction::ORDER_TYPES), ','),
            'transaction_date' => 'required|date_format:"Y-m-d"',
            'pickup_date' => 'required|date_format:"Y-m-d"',
            'delivery_date' => 'required|date_format:"Y-m-d"',
            'original_amount' => 'required|numeric',
            'discount' => 'numeric',
            'discount_amount' => 'numeric',
            'freight' => 'numeric',
            'total_amount' => 'required|numeric',
            'note' => 'nullable|string',
        ];

        foreach($this->request->get('transaction_lines') as $key => $val)
        {
            $rules['transaction_lines.'.$key.'.item_id'] = 'required';
            $rules['transaction_lines.'.$key.'.note'] = 'nullable|string';
            $rules['transaction_lines.'.$key.'.quantity'] = 'required|numeric';
            $rules['transaction_lines.'.$key.'.unit_price'] = 'required|numeric';
            $rules['transaction_lines.'.$key.'.amount'] = 'required|numeric';
        }

        return $rules;
    }
}
