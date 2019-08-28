<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use App\PaymentMean;

class StoreUpdatePaymentMean extends FormRequest
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
     *  {
     *      "payment_id" : 2,
     *      "payment_type" : "bank_transfer",
     *      "bank_account_id" : 1,
     *      "note" : "",
     *      "amount" : 5000,
     *      "payment_date" : "2019-08-27"
     *  }
     */

    public function rules()
    {
        return [
            'payment_id' => 'required',
            'payment_type' => 'required|in:'.join(array_keys(PaymentMean::PAYMENT_TYPES), ','),
            'bank_account_id' => 'required_if:payment_type,bank_transfer',
            'note' => 'nullable|string',
            'amount' => 'required|numeric',
            'payment_date' => 'required|date_format:"Y-m-d"'
        ];
    }
}
