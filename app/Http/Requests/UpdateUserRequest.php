<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            //
//            'first_name' => 'required',
//            'middle_name' => 'required',
//            'last_name' => 'required',
//            'email' => 'required|email',
            'password' => 'required|min:6',
        ];
    }

    public function attributes()
    {
        return [
//            'first_name' => 'First Name',
//            'middle_name' => 'Middle Name',
//            'last_name' => 'Last Name',
//            'email' => 'Email',
            'password' => 'Password',
        ];
    }
}
