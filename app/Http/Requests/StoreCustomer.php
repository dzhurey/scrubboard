<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use App\Rules\PhoneNumber;
use App\Customer;

class StoreCustomer extends FormRequest
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
        return [
            'name' => 'required|max:255',
            'email' => 'required|email',
            'phone_number' => ['required', 'max:15', new PhoneNumber],
            'birth_date' => 'required|date_format:"Y-m-d"',
            'gender' => 'required|in:'.join(array_keys(Customer::GENDERS), ','),
            'religion' => 'required|in:'.join(array_keys(Customer::RELIGIONS), ','),
            'billing_address' => 'required',
            'billing_district' => 'required|max:150',
            'billing_city' => 'required|max:150',
            'billing_country' => 'required|max:150',
            'billing_zip_code' => 'required|max:10',
            'shipping_address' => 'required_unless:is_same_address,on|nullable',
            'shipping_district' => 'required_unless:is_same_address,on|nullable|max:150',
            'shipping_city' => 'required_unless:is_same_address,on|nullable|max:150',
            'shipping_country' => 'required_unless:is_same_address,on|nullable|max:150',
            'shipping_zip_code' => 'required_unless:is_same_address,on|nullable|max:10',
            'bebe_name' => 'nullable|max:255',
            'is_same_address' => '',
            'bebe_birth_date' => 'nullable|date_format:"Y-m-d"',
            'bebe_gender' => 'in:'.join(array_keys(Customer::GENDERS), ','),
            'partner_type' => 'in:'.join(array_keys(Customer::PARTNER_TYPE), ','),
        ];
    }

    // public function getValidatorInstance()
    // {
    //     $this->cleanPhoneNumber();

    //     return parent::getValidatorInstance();
    // }

    // protected function cleanPhoneNumber()
    // {
    //     if($this->request->has('phone_number') && substr($this->request->get('phone_number'), 1, 1) === '0'){
    //         $this->merge([
    //             'phone_number' => '+62'.substr($this->request->get('phone_number'), 1)
    //         ]);
    //     }
    // }

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
