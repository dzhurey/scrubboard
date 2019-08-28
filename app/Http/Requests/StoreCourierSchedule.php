<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use App\CourierSchedule;
use App\Person;

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
     *     "courier_schedule_lines": [
     *     {
     *         "transaction_id": 10,
     *         "estimation_time": "10:30"
     *     }
     *     ]
     * }
     */
    public function rules()
    {
        $rules = [
            'person_id' => 'required',
            'vehicle_id' => 'required',
            'schedule_date' => 'required|date_format:"Y-m-d"'
        ];

        foreach($this->request->get('courier_schedule_lines') as $key => $val)
        {
            $rules['courier_schedule_lines.'.$key.'.transaction_id'] = 'required';
            $rules['courier_schedule_lines.'.$key.'.estimation_time'] = 'required|date_format:H:i';
        }

        return $rules;
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->personIsNotCourier()) {
                $validator->errors()->add('person', __('rules.person_not_courier'));
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
}
