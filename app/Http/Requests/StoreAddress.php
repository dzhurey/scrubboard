<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use App\Rules\PhoneNumber;
use App\Address;
use App\Customer;

class StoreAddress extends FormRequest
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
     *   "customer_id": 1,
     *   "is_shipping": true,
     *   "is_billing": false,
     *   "is_default": true,
     *   "address": "Jalan Kenangan",
     *   "district": "Cilandak",
     *   "city": "Jakarta Selatan",
     *   "country": "Indonesia",
     *   "zip_code": "82382",
     * }
     *
     */
    public function rules()
    {
        return [
            'customer_id' => 'required',
            'is_shipping' => '',
            'is_billing' => '',
            'is_default' => '',
            'address' => 'required|string',
            'district' => 'nullable|max:150',
            'city' => 'required|max:150',
            'country' => 'nullable|max:150',
            'zip_code' => 'nullable|string|max:10',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->customerIsNotFound()) {
                $validator->errors()->add('customer_id', __('rules.data_not_found'));
            }
        });
    }

    private function customerIsNotFound()
    {
        $item = Customer::find($this->request->get('customer_id'));

        if (empty($item)) {
            return true;
        }

        return false;
    }

    // protected function sanitizeAttributes()
    // {
    //     // if($this->request->has('bebe_birth_date')){
    //     //     dd($this->request);
    //     //     $this->request->merge([
    //     //         'phone_number' => str_replace('-', '', $this->request->get('phone_number'));
    //     //     ]);
    //     // }
    // }
}
