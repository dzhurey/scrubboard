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
     */
    public function rules()
    {
        // dd($this->request);
        foreach($this->request->get('payment_means') as $key => $val)
        {
            $rules['payment_means.'.$key.'.payment_id'] = 'required';
            $rules['payment_means.'.$key.'.payment_type'] = 'required|in:'.join(array_keys(PaymentMean::PAYMENT_TYPES), ',');
            $rules['payment_means.'.$key.'.bank_account_id'] = 'required_if:payment_type,bank_transfer';
            $rules['payment_means.'.$key.'.note'] = 'nullable|string';
            $rules['payment_means.'.$key.'.amount'] = 'required|numeric';
            $rules['payment_means.'.$key.'.payment_date'] = 'required|date_format:"Y-m-d"';
        }
        
        return $rules;
    }
}
