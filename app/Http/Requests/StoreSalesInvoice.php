<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use App\Transaction;
use App\TransactionLine;

class StoreSalesInvoice extends FormRequest
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
     *      "customer_id": 1,
     *      "order_type": "general",
     *      "transaction_date": "2019-08-20",
     *      "pickup_date": "2019-08-21",
     *      "delivery_date": "2019-08-22",
     *      "due_date": "2019-08-22",
     *      "original_amount": 70000,
     *      "discount": 0,
     *      "discount_amount": 0,
     *      "freight": 10000,
     *      "total_amount": 80000,
     *      "note": "",
     *      "is_own_address": true,
     *      "agent_id": 1,
     *      "transaction_lines": [
     *          {
     *              "id": 2, (if update add the id, if new line just fill with null, if create not need this key)
     *              "item_id": 1,
     *              "note": "",
     *              "quantity": 2,
     *              "discount": 0,
     *              "discount_amount": 0,
     *              "unit_price": 35000,
     *              "amount": 70000,
     *              "status": "canceled" (if update)
     *          }
     *      ]
     *  }
     */
    public function rules()
    {
        $rules = [
            'customer_id' => 'required',
            'agent_id' => 'required',
            'order_type' => 'required|in:'.join(array_keys(Transaction::ORDER_TYPES), ','),
            'transaction_date' => 'required|date_format:"Y-m-d"',
            'pickup_date' => 'required|date_format:"Y-m-d"',
            'due_date' => 'sometimes|required|date_format:"Y-m-d"',
            'delivery_date' => 'required|date_format:"Y-m-d"',
            'original_amount' => 'required|numeric',
            'discount' => 'required|numeric',
            'discount_amount' => 'required|numeric',
            'freight' => 'required|numeric',
            'total_amount' => 'required|numeric',
            'note' => 'nullable|string',
            'is_own_address' => 'required|boolean',
            'order_id' => 'nullable',
            'transaction_lines' => 'required|array',
        ];

        foreach($this->request->get('transaction_lines') as $key => $val)
        {
            $rules['transaction_lines.'.$key.'.id'] = 'sometimes|nullable';
            $rules['transaction_lines.'.$key.'.item_id'] = 'required';
            $rules['transaction_lines.'.$key.'.brand_id'] = 'required';
            $rules['transaction_lines.'.$key.'.color'] = 'nullable|string';
            $rules['transaction_lines.'.$key.'.note'] = 'nullable|string';
            $rules['transaction_lines.'.$key.'.bor'] = 'required|string';
            $rules['transaction_lines.'.$key.'.quantity'] = 'required|numeric';
            $rules['transaction_lines.'.$key.'.unit_price'] = 'required|numeric';
            $rules['transaction_lines.'.$key.'.discount'] = 'required|numeric';
            $rules['transaction_lines.'.$key.'.discount_amount'] = 'required|numeric';
            $rules['transaction_lines.'.$key.'.amount'] = 'required|numeric';
            $rules['transaction_lines.'.$key.'.status'] = 'sometimes|required|in:'.join(array_keys(TransactionLine::STATUS), ',');
        }

        return $rules;
    }
}
