<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use App\Rules\PhoneNumber;
use App\Agent;

class StoreUpdateAgent extends FormRequest
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
            'name' => 'required|max:255',
            'email' => 'nullable|email',
            'phone_number' => ['max:15', new PhoneNumber],
            'mobile_number' => ['required', 'max:15', new PhoneNumber],
            'address' => 'required',
            'district' => 'required|max:150',
            'sub_district' => 'required|max:150',
            'city' => 'required|max:150',
            'country' => 'required|max:150',
            'zip_code' => 'required|max:10',
            'contact_name' => 'required|max:255',
            'contact_phone_number' => ['max:15', new PhoneNumber],
            'contact_mobile_number' => ['required', 'max:15', new PhoneNumber],
            'agent_group_id' => 'required',
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
