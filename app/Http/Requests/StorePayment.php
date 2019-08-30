<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use App\Payment;
use App\PaymentMean;
use App\BankAccount;
use App\Bank;

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
     * {
     *     "customer_id": 1,
     *     "payment_date": "2019-08-24",
     *     "note": "alalal",
     *     "transaction_id": 25,
     *     "payment_type": "bank_transfer",
     *     "bank_account_id": 1,
     *     "bank_id": 2,
     *     "amount": 15000,
     *     "total_amount": 15000
     * }
     */

    public function rules()
    {
        $rules = [
            'customer_id' => 'required',
            'payment_date' => 'required|date_format:"Y-m-d"',
            'note' => 'nullable|string',
            'transaction_id' => 'required',
            'payment_type' => 'required|in:'.join(array_keys(PaymentMean::PAYMENT_TYPES), ','),
            'bank_account_id' => 'required_if:payment_type,bank_transfer',
            'bank_id' => 'required_if:payment_type,credit_card',
            'amount' => 'required|numeric',
            'total_amount' => 'required|numeric',
        ];

        // foreach($this->request->get('payment_lines') as $key => $val)
        // {
        //     $rules['payment_lines.'.$key.'.transaction_id'] = 'required';
        //     $rules['payment_lines.'.$key.'.amount'] = 'required|numeric';
        // }

        return $rules;
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->bankAccountIdIsNotFound()) {
                $validator->errors()->add('bank_account', __('rules.data_not_found'));
            }

            if ($this->bankIdIsNotFound()) {
                $validator->errors()->add('bank', __('rules.data_not_found'));
            }

            if ($this->transactionIdIsNotFound()) {
                $validator->errors()->add('transaction', __('rules.data_not_found'));
            }

            if ($this->customerIdIsNotFound()) {
                $validator->errors()->add('customer', __('rules.data_not_found'));
            }
        });
    }

    public function bankAccountIdIsNotFound()
    {
        $bank_account = BankAccount::find($this->request->get('bank_account_id'));

        if (empty($bank_account)) {
            return true;
        }

        return false;
    }

    public function bankIdIsNotFound()
    {
        $bank = Bank::find($this->request->get('bank_id'));

        if (empty($bank)) {
            return true;
        }

        return false;
    }

    public function transactionIdIsNotFound()
    {
        $transaction = Transaction::find($this->request->get('transaction_id'));

        if (empty($transaction)) {
            return true;
        }

        return false;
    }

    public function customerIdIsNotFound()
    {
        $customer = Customer::find($this->request->get('customer_id'));

        if (empty($customer)) {
            return true;
        }

        return false;
    }
}
