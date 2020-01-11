<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use App\Promo;

class StorePromo extends FormRequest
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
            'code' => 'required|max:255',
            'percentage' => 'required|numeric|max:100|min:0',
            'max_promo' => 'required|numeric',
            'start_promo' => 'required|date_format:"Y-m-d\TH:i:sP"',
            'end_promo' => 'required|date_format:"Y-m-d\TH:i:sP"',
            'type' => 'required|in:'.join(array_keys(Promo::PAYMENT_METHODS), ',')
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
