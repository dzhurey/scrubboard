<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use App\Rules\PhoneNumber;
use App\Address;

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
     *  "name" : "Agent C",
	 *  "email" : "agentc@agent.com",
	 *  "phone_number" : "022211113",
	 *  "mobile_number" : "088111333222",
	 *  "address" : "Jalan",
	 *  "district" : "Jalan",
	 *  "sub_district" : "Jalan Sub",
	 *  "city" : "Kota",
	 *  "country" : "Negara",
	 *  "zip_code" : "620000",
	 *  "contact_name" : "Agent Nama",
	 *  "contact_phone_number" : "022213333",
	 *  "contact_mobile_number" : "08999922211",
	 *  "agent_group_id" : 2
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
