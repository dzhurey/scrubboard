<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use App\Payment;

class StorePayment extends FormRequest
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
     *   {
     *       "customer_id" : 1,
     *       "payment_date" : "2019-08-24",
     *       "note" : "",
     *       "total_amount" : 13000,
     *       "payment_lines" : [
     *           {
     *               "transaction_id" : 1,
     *               "amount" : 7000
     *           },
     *           {
     *               "transaction_id" : 2,
     *               "amount" : 6000
     *           }
     *       ]
     *   }
     */

    public function rules()
    {
        $rules = [
            'customer_id' => 'required',
            'payment_date' => 'required|date_format:"Y-m-d"',
            'note' => 'nullable|string',
            'total_amount' => 'required|numeric'
        ];

        foreach($this->request->get('payment_lines') as $key => $val)
        {
            $rules['payment_lines.'.$key.'.transaction_id'] = 'required';
            $rules['payment_lines.'.$key.'.amount'] = 'required|numeric';
        }

        return $rules;
    }
}
