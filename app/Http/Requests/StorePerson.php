<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use App\Person;

class StorePerson extends FormRequest
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
            'email' => 'required|email|unique:users',
            'password' => 'required|password',
            'confirm_password' => 'required|password|same:password',
            'phone_number' => 'required|max:15',
            'birth_date' => 'required|date_format:"Y-m-d"',
            'gender' => 'required|in:'.join(array_keys(Person::GENDERS), ','),
            'religion' => 'required|in:'.join(array_keys(Person::RELIGIONS), ','),
            'address' => 'required',
            'district' => 'required|max:150',
            'city' => 'required|max:150',
            'country' => 'required|max:150',
            'zip_code' => 'required|max:10',
            'role' => 'required|in:'.join(array_keys(Person::ROLES), ','),
        ];
    }

    // public function withValidator(Validator $validator)
    // {
    //     // $validator->after(function ($validator) {
    //     //     if ($this->somethingElseIsInvalid()) {
    //     //         $validator->errors()->add('field', 'Something is wrong with this field!');
    //     //     }
    //     // });
    // }

    // public function messages()
    // {
    //     return [
    //         'name.required' => 'Name is required',
    //         'email.required' => 'Email is required',
    //     ];
    // }

    // public function attributes()
    // {
    //     // return [
    //     //     'email' => 'email address',
    //     // ];
    // }
}
