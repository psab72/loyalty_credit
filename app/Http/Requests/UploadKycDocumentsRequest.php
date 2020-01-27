<?php

namespace App\Http\Requests;

use App\Model\KycDocument;
use App\Model\KycFile;
use Illuminate\Foundation\Http\FormRequest;

class UploadKycDocumentsRequest extends FormRequest
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
    public function rules(KycDocument $kycDocument)
    {
        $rules = $this->kycDocumentsRules($kycDocument);

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

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        $kycDocuments = KycDocument::where('country_id', auth()->user()->country_id)
            ->get();

        $attributes = [];
        foreach($kycDocuments as $k) {
            $attributes[$k->name] = $k->doc_name;
        }

        $attributes['middle_name'] = 'First Name';
        $attributes['middle_name'] = 'Middle Name';
        $attributes['last_name'] = 'Last Name';
        $attributes['email'] = 'Email';
        $attributes['date_of_birth'] = 'Date of Birth';
        $attributes['place_of_birth'] = 'Place of Birth';
        $attributes['house_no'] = 'House No/Bldg./Street';
        $attributes['brgy_id'] = 'Barangay';
        $attributes['city_id'] = 'City';
        $attributes['province_id'] = 'Province';
        $attributes['nationality_id'] = 'Nationality';
        $attributes['mobile_number'] = 'Mobile Number';
        $attributes['establishment_name'] = 'Establishment Name';
        $attributes['source_of_income'] = 'Source Of Income';

        return $attributes;
    }

    /**
     * @param $kycDocument
     * @return mixed
     */
    public function kycDocumentsRules($kycDocument)
    {
        $kycDocumentIds = $kycDocument->getKycDocumentsId();
        foreach(config('constants.kyc_documents') as $i => $c) {
            if(in_array($i, $kycDocumentIds)) {
                $count = KycFile::where('doc_type_id', $i)
                    ->where('merchant_id', auth()->user()->id)
                    ->count();

                if(!empty($count)) {
                    $rules[$c] = 'file|image|max:3072';
                } else {
                    $rules[$c] = 'required|file|image|max:3072';
                }
            }
        }

        return $rules;
    }
}
