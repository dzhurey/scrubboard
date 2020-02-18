<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use App\PaymentMean;

class StorePaymentMean extends FormRequest
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
     *       "payment_means" :
     *       [
     *           {
     *               "payment_id" : 2,
     *               "payment_type" : "bank_transfer",
     *               "bank_account_id" : 1,
     *               "note" : "",
     *               "amount" : 9000,
     *               "payment_date" : "2019-08-27"
     *           },
     *           {
     *               "payment_id" : 2,
     *               "payment_type" : "cash",
     *               "bank_account_id" : "",
     *               "note" : "",
     *               "amount" : 1000,
     *               "payment_date" : "2019-08-27"
     *           }
     *       ]
     *   }
     */

    public function rules()
    {
        // dd($this->request);
        foreach($this->request->get('payment_means') as $key => $val)
        {
            $rules['payment_means.'.$key.'.payment_id'] = 'required';
            $rules['payment_means.'.$key.'.payment_type'] = 'required|in:'.implode(',', array_keys(PaymentMean::PAYMENT_METHODS));
            $rules['payment_means.'.$key.'.bank_account_id'] = 'required_if:payment_type,bank_transfer';
            $rules['payment_means.'.$key.'.note'] = 'nullable|string';
            $rules['payment_means.'.$key.'.amount'] = 'required|numeric';
            $rules['payment_means.'.$key.'.payment_date'] = 'required|date_format:"Y-m-d"';
        }

        return $rules;
    }
}
