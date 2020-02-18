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
     *
     * input json
     * {
     *      "name": "Promo Tahun Baru",
     *      "code": "FEB",
     *      "quota": null,
     *      "percentage": 10,
     *      "max_promo": 20000,
     *      "start_promo": "2020-02-01 00:00:00",
     *      "end_promo": "2020-02-20 15:03:01",
     *      "type": "promo"
     * }
     *
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'code' => 'required|unique:promos|max:255',
            'quota' => 'nullable',
            'percentage' => 'required|numeric|max:100|min:0',
            'max_promo' => 'required|numeric',
            'start_promo' => 'required|date_format:"Y-m-d"',
            'end_promo' => 'required|date_format:"Y-m-d"',
            'type' => 'required|in:'.implode(',', array_keys(Promo::PROMO_TYPES))
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
