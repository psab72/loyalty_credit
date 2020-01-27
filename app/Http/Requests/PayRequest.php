<?php

namespace App\Http\Requests;

use App\Model\Ewallet;
use Illuminate\Foundation\Http\FormRequest;

class PayRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
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
            'amount' => 'required|amount',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->insufficientBalance()) {
                $validator->errors()->add('amount', 'Insufficient Balance. Please add funds to your eWallet.');
            }
        });
    }

    public function insufficientBalance()
    {
        $eWalletData = Ewallet::where('merchant_id', auth()->user()->id)
            ->first();

        return $eWalletData->amount < request()->amount;
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'amount' => 'Amount'
        ];
    }
}
