<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use App\CourierSchedule;
use App\Transaction;
use App\TransactionLine;
use App\Person;
use App\Address;

class StoreCourierSchedule extends FormRequest
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
     *     "person_id": 1,
     *     "vehicle_id": 1,
     *     "schedule_date": "2019-08-29",
     *     "address_id": 1,
     *     "courier_schedule_lines": [
     *     {
     *         "transaction_line_id": 10,
     *         "estimation_time": "10:30",
     *         "status": "canceled", (if: update)
     *     }
     *     ]
     * }
     */
    public function rules()
    {
        $rules = [
            'person_id' => 'required',
            'vehicle_id' => 'required',
            'address_id' => '',
            'schedule_date' => 'required|date_format:"Y-m-d"',
            'courier_schedule_lines' => 'array',
        ];

        foreach($this->request->get('courier_schedule_lines') as $key => $val)
        {
            $rules['courier_schedule_lines.'.$key.'.transaction_line_id'] = 'required';
            $rules['courier_schedule_lines.'.$key.'.estimation_time'] = 'nullable|date_format:H:i';
            $rules['courier_schedule_lines.'.$key.'.status'] = 'sometimes|required|in:'.implode(',', array_keys(TransactionLine::STATUS));
        }

        return $rules;
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->personIsNotCourier()) {
                $validator->errors()->add('person', __('rules.person_not_courier'));
            }
            if (!empty($this->request->get('address_id'))) {
                if ($this->addressIsNotFound()) {
                    $validator->errors()->add('address_id', __('rules.data_not_found'));
                }
                if ($this->addressIsNotShipping()) {
                    $validator->errors()->add('address_id', __('rules.address_is_not_shipping'));
                }
            } else {
                if ($this->transactionNotUseAgentAddress()) {
                    $validator->errors()->add('address_id', __('rules.transaction_not_use_own_address'));
                }
            }
        });
    }

    public function personIsNotCourier()
    {
        $person = Person::find($this->request->get('person_id'));

        if (empty($person)) {
            return true;
        }

        if ($person->user->role !== 'courier') {
            return true;
        }

        return false;
    }

    private function addressIsNotFound()
    {
        $item = Address::find($this->request->get('address_id'));

        if (empty($item)) {
            return true;
        }

        return false;
    }

    private function addressIsNotShipping()
    {
        $item = Address::find($this->request->get('address_id'));

        if (empty($item)) {
            return true;
        }

        return false;
    }

    private function transactionNotUseAgentAddress()
    {
        $transaction_line_id = $this->request->get('courier_schedule_lines')[0]['transaction_line_id'];
        $transaction_line = TransactionLine::find($transaction_line_id);
        if ($transaction_line->transaction->is_own_address) {
            return true;
        }

        return false;
    }
}
