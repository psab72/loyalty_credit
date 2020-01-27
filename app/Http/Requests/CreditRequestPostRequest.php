<?php

namespace App\Http\Requests;

use App\Model\CreditRequest;
use App\User;
use Illuminate\Foundation\Http\FormRequest;

class CreditRequestPostRequest extends FormRequest
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
            'lender_id' => 'required',
            'payment_term_id' => 'required',
            'amount' => 'required|numeric'
            //
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
            if (empty($this->userVerified())) {
                $validator->errors()->add('user', 'You are not permitted to apply for a loan. Please complete your Personal Information verification before applying.');
            }

            if(!empty($this->checkOngoingLoan())) {
                $validator->errors()->add('user', 'You have an ongoing/processing Loan.');
            }

            if(auth()->user()->available_credit < request()->amount) {
                $validator->errors()->add('amount', 'Available credit is not sufficient.');
            }

//            if(request()->amount < config('constants.min_loan_amount')) {
//                $validator->errors()->add('amount', 'Loan Amount must be greater than ' . config('constants.min_loan_amount'));
//            }
//
//            if(request()->amount > config('constants.max_loan_amount')) {
//                $validator->errors()->add('amount', 'Loan Amount must be less than ' . config('constants.max_loan_amount'));
//            }
        });
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'lender_id' => 'Lender',
            'payment_term_id' => 'Payment Term',
            'amount' => 'Amount'
        ];
    }

    public function userVerified()
    {
        return User::where('id', auth()->user()->id)
            ->where('is_verified', 1)
            ->first();
    }

    public function checkOngoingLoan()
    {
        return CreditRequest::where('merchant_id', auth()->user()->id)
            ->where('status', '!=', 'closed')
            ->count();
    }
}
