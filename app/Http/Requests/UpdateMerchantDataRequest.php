<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMerchantDataRequest extends FormRequest
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
        $rules['first_name'] = 'required';
        $rules['middle_name'] = '';
        $rules['last_name'] = 'required';
        $rules['email'] = 'required';
        $rules['date_of_birth'] = 'sometimes|required|date_format:Y-m-d';
        $rules['place_of_birth'] = 'sometimes|required';
        $rules['house_no'] = 'sometimes|required';
        $rules['brgy_id'] = 'sometimes|required';
        $rules['city_id'] = 'sometimes|required';
        $rules['province_id'] = 'sometimes|required';
        $rules['nationality_id'] = 'sometimes|required';
        $rules['mobile_number'] = 'sometimes|required';
        $rules['establishment_name'] = 'sometimes|required';
        $rules['source_of_incoe'] = 'sometimes|required';

        return $rules;
    }
}
