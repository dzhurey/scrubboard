<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use App\Payment;
use App\SalesInvoice;
use App\PaymentMean;
use App\BankAccount;
use App\Bank;
use App\Transaction;
use App\Customer;

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
     *     "note": "alalal",
     *     "transaction_id": 25,
     *     "total_amount": 15000,
     *     "payment_lines": [
     *       {
     *         "payment_method": "bank_transfer", // options: cash, bank_transfer, credit_card, other, bebewash
     *         "payment_type": "acquittance", // options: down_payment, acquittance
     *         "payment_date": "2019-08-24",
     *         "amount": 15000,
     *         "note": "asdads",
     *         "receiver_name": "Suryadi", // required if payment_method = bank_transfer
     *         "bank_account_id": 1, // required if payment_method = bank_transfer
     *         "credit_card_no": "023902392233232", // required if payment_method = credit_card
     *         "bank_id": null // required if payment_method = credit_card
     *       }
     *     ]
     * }
     */

    public function rules()
    {
        $rules = [
            'customer_id' => 'required',
            'note' => 'nullable|string',
            'transaction_id' => 'required',
            'total_amount' => 'required|numeric',
            'payment_lines' => 'required|array',
        ];

        foreach($this->request->get('payment_lines') as $key => $val)
        {
            $rules['payment_lines.'.$key.'.payment_method'] = 'required|in:'.implode(',', array_keys(PaymentMean::PAYMENT_METHODS));
            $rules['payment_lines.'.$key.'.payment_type'] = 'required|in:'.implode(',', array_keys(PaymentMean::PAYMENT_TYPES));
            $rules['payment_lines.'.$key.'.payment_date'] = 'required|date_format:"Y-m-d"';
            $rules['payment_lines.'.$key.'.amount'] = 'required|numeric';
            $rules['payment_lines.'.$key.'.note'] = 'nullable|string';
            $rules['payment_lines.'.$key.'.credit_card_no'] = 'required_if:payment_lines.'.$key.'.payment_method,credit_card|string';
            $rules['payment_lines.'.$key.'.receiver_name'] = 'required_if:payment_lines.'.$key.'.payment_method,bank_transfer';
            $rules['payment_lines.'.$key.'.bank_account_id'] = 'required_if:payment_lines.'.$key.'.payment_method,bank_transfer';
            $rules['payment_lines.'.$key.'.bank_id'] = 'required_if:payment_lines.'.$key.'.payment_method,credit_card';
        }

        return $rules;
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $totalDp = 0;
            $totalAmount = 0;
            foreach($this->request->get('payment_lines') as $key => $val)
            {
                if ($val['payment_method'] == 'bank_transfer' && !empty($val['bank_account_id']) && $this->bankAccountIdIsNotFound($val['bank_account_id'])) {
                    $validator->errors()->add('bank_account', __('rules.data_not_found'));
                }

                if ($val['payment_method'] == 'credit_card' && !empty($val['bank_id']) && $this->bankIdIsNotFound($val['bank_id'])) {
                    $validator->errors()->add('bank', __('rules.data_not_found'));
                }

                if ($val['payment_type'] == 'down_payment') {
                    $totalDp += $val['amount'];
                }
                $totalAmount += $val['amount'];
            }
            if ($this->transactionIdIsNotFound()) {
                $validator->errors()->add('transaction', __('rules.data_not_found'));
                return false;
            }

            if ($this->customerIdIsNotFound()) {
                $validator->errors()->add('customer', __('rules.data_not_found'));
                return false;
            }

            $transaction = SalesInvoice::find($this->request->get('transaction_id'));

            // if ($this->request->get('total_amount') > $transaction->total_amount) {
            //     $validator->errors()->add('total_amount', __('rules.more_than_amount'));
            // }

            if ($totalAmount != $this->request->get('total_amount')) {
                $validator->errors()->add('total_amount', __('rules.not_equal_with_lines'));
            }
        });
    }

    public function bankAccountIdIsNotFound($bankAccountId)
    {
        $bank_account = BankAccount::find($bankAccountId);

        if (empty($bank_account)) {
            return true;
        }

        return false;
    }

    public function bankIdIsNotFound($bankId)
    {
        $bank = Bank::find($bankId);

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
