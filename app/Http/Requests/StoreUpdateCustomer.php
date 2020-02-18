<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use App\Rules\PhoneNumber;
use App\Customer;

class StoreUpdateCustomer extends FormRequest
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
            'email' => 'nullable|email',
            'phone_number' => ['required', 'max:15', new PhoneNumber],
            'birth_date' => 'nullable|date_format:"Y-m-d"',
            'gender' => 'required|in:'.implode(',', array_keys(Customer::GENDERS)),
            'religion' => 'nullable|in:'.implode(',', array_keys(Customer::RELIGIONS)),
            'bebe_name' => 'nullable|max:255',
            'price_id' => 'required',
            'bebe_birth_date' => 'nullable|date_format:"Y-m-d"',
            'bebe_gender' => 'nullable|in:'.implode(',', array_keys(Customer::GENDERS)),
            'partner_type' => 'in:'.implode(',', array_keys(Customer::PARTNER_TYPE)),
            'instagram' => 'nullable',
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
