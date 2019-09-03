<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use App\PaymentMean;

class StoreUpdatePerson extends FormRequest
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
     *  {
     *      "name" : "M Fadjrin Hidayah",
     *      "password" : "qwertyuiop",
     *      "confirm_password" : "qwertyuiop",
     *      "phone_number" : "085666123444",
     *      "birth_date" : "2019-06-21",
     *      "gender" : "male",
     *      "religion" : "",
     *      "address" : "alamat",
     *      "district" : "disini",
     *      "city" : "disana",
     *      "country" : "mana",
     *      "zip_code" : "12490",
     *      "role" : "operation"
     *  }
     */

    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'password' => 'sometimes|required|min:8',
            'confirm_password' => 'sometimes|required|same:password',
            'phone_number' => ['required', 'max:15', new PhoneNumber],
            'birth_date' => 'required|date_format:"Y-m-d"',
            'gender' => 'required|in:'.join(array_keys(Person::GENDERS), ','),
            'religion' => 'nullable|in:'.join(array_keys(Person::RELIGIONS), ','),
            'address' => 'required',
            'district' => 'required|max:150',
            'city' => 'required|max:150',
            'country' => 'required|max:150',
            'zip_code' => 'required|max:10',
            'role' => 'required|in:'.join(array_keys(User::ROLES), ','),
        ];
    }
}
