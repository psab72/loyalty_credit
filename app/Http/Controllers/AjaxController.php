<?php

namespace App\Http\Controllers;

use App\Http\Requests\KycUpdateRequest;
use App\Http\Requests\PayRequest;
use App\Http\Requests\StepOneRegisterRequest;
use App\Model\Billing;
use App\Model\CreditRequest;
use App\Model\Ewallet;
use App\Model\Kyc;
use App\Model\KycFile;
use App\Model\KycHistory;
use App\Model\Lender;
use App\Model\Notification;
use App\Model\PaymentTerm;
use App\Model\Refbrgy;
use App\Model\Refcitymun;
use App\Model\Transaction;
use App\User;
use Illuminate\Http\Request;
use Validator;
use Auth;
use DB;

class AjaxController extends Controller
{
    //
    /** Get sales data per month
     * @param CreditRequest $creditRequest
     * @param Transaction $transaction
     * @param Billing $billing
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function salesDataPerMonth(CreditRequest $creditRequest, Transaction $transaction, Billing $billing)
    {
        $amountLentPerMonthWithRange = $creditRequest->amountLentPerMonthWithRange();
        $amountAtRiskPerMonthWithRange = $transaction->amountAtRiskPerMonthWithRange();
        $lateBillsPerMonthWithRange = $billing->lateBillsPerMonthWithRange();
        $repaidPerMonthWithRange = $billing->repaidPerMonthWithRange();

        return response([
            'amount_lent' => $amountLentPerMonthWithRange,
            'amount_at_risk' => $amountAtRiskPerMonthWithRange,
            'late_bills' => $lateBillsPerMonthWithRange,
            'repaid' => $repaidPerMonthWithRange
        ]);
    }

    /** Get Kyc Data
     * @param Kyc $kyc
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function kycData(Kyc $kyc, KycFile $kycFile, User $user)
    {
        if(!empty($kyc->getKycDataById())) {
            $kycData = $kyc->getKycDataById();
        } else {
            $kycData = $user->select('users.*',
                DB::raw('CONCAT(users.first_name, \' \', users.last_name) as merchant_name'),
                'refprovince.provDesc as province',
                'refcitymun.citymunDesc as city',
                'refbrgy.brgyDesc as barangay')
                ->leftJoin('refprovince', 'users.province_id', '=', 'refprovince.provCode')
                ->leftJoin('refcitymun', 'users.city_id', '=', 'refcitymun.id')
                ->leftJoin('refbrgy', 'users.brgy_id', '=', 'refbrgy.id')
                ->first();

        }

//        dd($kycData);
        return response([
            'kyc' => $kycData,
            'kyc_files' => $kycFile->getKycFiles()
        ]);
    }

    /**
     * @param Kyc $kyc
     * @param KycUpdateRequest $kycUpdateRequest
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function updateKyc(Kyc $kyc, KycUpdateRequest $kycUpdateRequest, User $user, Notification $notification)
    {
        $validated = $kycUpdateRequest->validated();

        $kyc->updateKycData();

        //if for verification also update user to is verified true.
        if(request()->status == 'verified') {
            $kycData = $kyc->find(request()->kyc_id);

            $user->where('id', $kycData->merchant_id)
                ->update(['is_verified' => 1]);
        }

        request()->session()->flash('success', 'KYC Updated!');

        $message = '';
        if(request()->status == 'verified') {
            $message = 'Successfully Verified KYC';
        } elseif(request()->status == 'on_hold') {
            $message = 'KYC Held';
        } elseif(request()->status == 'rejected') {
            $message = 'KYC Rejected';
        }

        $notification->insert([
            'merchant_id' => $kycData->merchant_id,
            'message' => $message,
        ]);

        return response([
            'status' => 200,
            'message' => 'success'
        ]);
    }

    /**
     * @param Kyc $kyc
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function kycAssign(Kyc $kyc)
    {
        $kyc->updateKycAssignedTo();

        request()->session()->flash('success', 'KYC Updated!');

        return response([
            'status' => 200,
            'message' => 'success'
        ]);
    }

    /**
     * @param Lender $lender
     * @param PaymentTerm $paymentTerm
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function computeAmortization(Lender $lender, PaymentTerm $paymentTerm)
    {
//        $lenderData = $lender->where('id', request()->lender_id)
//            ->first();

        $paymentTermData = $paymentTerm->where('id', request()->payment_term_id)
            ->first();

        $amountRequest = (float) request()->amount;
        $interestRate = (float) request()->interest_rate * 0.01;
        $noOfMonths = $paymentTermData->no_of_months;

//        $interestAmount = number_format((float) request()->amount * (request()->interest_rate), 2, '.', '');

        $interestAmount = $amountRequest * $interestRate * $noOfMonths;
        $interestAmount = number_format($interestAmount, 2, '.', '');


        $totalAmount = ($amountRequest + $interestAmount);

        $monthlyAmortization =  number_format((float) ($totalAmount / $paymentTermData->no_of_months), 2, '.', '');
//
//        dump('interest amount ' . $interestAmount);
//        dump('basic ' . $basicAmount);
//        dump('monthly ' . $monthlyAmortization);
//        dump('no of months ' . $paymentTermData->no_of_months);
//
//        die;
//        $monthlyAmortization =  number_format((float) ((request()->amount) / $paymentTermData->no_of_months), 2, '.', '');

        return response([
            'data' => [
                'monthly_amortization' => $monthlyAmortization,
                'interest_amount' => $interestAmount,
            ],
            'status' => 200,
            'message' => 'success'
        ]);
    }


    public function stepOneRegister(User $user)
    {
        $rules = [
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|max:30',
        ];

        $attributeNames = [
            'email'    => 'Email',
            'password' => 'Password',
        ];

        $validator = Validator::make(request()->all(), $rules);
        $validator->setAttributeNames($attributeNames);

        if ($validator->fails()) {
            return response(['errors' => TRUE,
                'messages' => $validator->errors()
            ]);
        } else {
            $user->stepOneRegister();
        }
    }

    public function stepTwoRegister(User $user)
    {
        $rules = [
            'verification_code'    => 'required|integer',
        ];

        $attributeNames = [
            'verification_code'    => 'Verification Code',
        ];

        $validator = Validator::make(request()->all(), $rules);
        $validator->setAttributeNames($attributeNames);

        $validator->after(function ($validator) use ($user) {
            $userData = $user->where('email', request()->email)
                ->first();

            if ($userData->verification_code != request()->verification_code) {
                $validator->errors()->add('verification_code', 'Invalid Verification Code.');
            }
        });

        if ($validator->fails()) {
            return response(['errors' => TRUE,
                'messages' => $validator->errors()
            ]);
        } else {
            return response(['errors' => FALSE,
                'messages' => 'Success'
            ]);
        }
    }

    public function stepThreeRegister(User $user)
    {
        $rules = [
            'first_name'    => 'required',
            'middle_name'   => 'required',
            'last_name'     => 'required',
            'establishment_name'     => 'required',
            'mobile_number'     => 'required|integer|unique:users',
        ];

        $attributeNames = [
            'first_name'    => 'First Name',
            'middle_name'    => 'Middle Name',
            'last_name'    => 'Last Name',
            'establishment_name'    => 'Establishment Name',
            'mobile_number'    => 'Mobile Number',
        ];

        $validator = Validator::make(request()->all(), $rules);
        $validator->setAttributeNames($attributeNames);

        if ($validator->fails()) {
            return response(['errors' => TRUE,
                'messages' => $validator->errors()
            ]);
        } else {
            $user->where('email', request()->email)
                ->update([
                    'first_name' => request()->first_name,
                    'middle_name' => request()->middle_name,
                    'last_name' => request()->last_name,
                    'establishment_name' => request()->establishment_name,
                    'mobile_number' => request()->mobile_number,
                ]);

            return response(['errors' => FALSE,
                'messages' => 'Success'
            ]);
        }
    }

    public function stepFourRegister(User $user)
    {
        $rules = [
            'date_of_birth'    => 'required|date_format:Y-m-d',
            'place_of_birth' => 'required'
        ];

        $attributeNames = [
            'date_of_birth' => 'Date of birth',
            'place_of_birth' => 'Place of birth'
        ];

        $validator = Validator::make(request()->all(), $rules);
        $validator->setAttributeNames($attributeNames);

        if ($validator->fails()) {
            return response(['errors' => TRUE,
                'messages' => $validator->errors()
            ]);
        } else {
            $user->where('email', request()->email)
                ->update([
                    'date_of_birth' => request()->date_of_birth,
                    'place_of_birth' => request()->place_of_birth
                ]);

            return response(['errors' => FALSE,
                'messages' => 'Success'
            ]);
        }
    }

    public function stepFiveRegister(User $user)
    {
        $rules = [
            'nationality_id'    => 'required',
            'source_of_income'    => 'required',
        ];

        $attributeNames = [
            'nationality_id' => 'Nationality',
            'source_of_income' => 'Source of income',
        ];

        $validator = Validator::make(request()->all(), $rules);
        $validator->setAttributeNames($attributeNames);

        if ($validator->fails()) {
            return response(['errors' => TRUE,
                'messages' => $validator->errors()
            ]);
        } else {
            $user->where('email', request()->email)
                ->update([
                    'nationality_id' => request()->nationality_id,
                    'source_of_income' => request()->source_of_income,
                ]);

            return response(['errors' => FALSE,
                'messages' => 'Success'
            ]);
        }
    }

    public function stepSixRegister(User $user, Kyc $kyc, Notification $notification)
    {
        $rules = [
            'house_no'    => 'required',
            'province_id'    => 'required',
            'city_id'    => 'required',
            'brgy_id'    => 'required',
        ];

        $attributeNames = [
            'house_no'    => 'House No./Bldg/Street',
            'province_id'    => 'Province',
            'city_id'    => 'City',
            'brgy_id'    => 'Barangay',
        ];

        $validator = Validator::make(request()->all(), $rules);
        $validator->setAttributeNames($attributeNames);

        if ($validator->fails()) {
            return response(['errors' => TRUE,
                'messages' => $validator->errors()
            ]);
        } else {
            $user->where('email', request()->email)
                ->update([
                    'house_no'    => request()->house_no,
                    'province_id'    => request()->province_id,
                    'city_id'    => request()->city_id,
                    'brgy_id'    => request()->brgy_id,
                ]);

            $userData = $user->where('email', request()->email)
                ->first();

            $kyc->insert([
                'merchant_id' => $userData->id,
            ]);

            $notification->insert([
                 'message' => 'New User ' . $userData->email . ' Registered.'
            ]);

            return response(['errors' => FALSE,
                'messages' => 'Success'
            ]);
        }
    }

    public function getCities(Refcitymun $refcitymun)
    {
        return $refcitymun->orderBy('citymunDesc')->where('provCode', request()->province_id)
            ->get();
    }

    public function getBarangays(Refbrgy $refbrgy)
    {
        return $refbrgy->orderBy('brgyDesc')->where('citymunCode', request()->city_id)
            ->get();
    }

    public function loginUser()
    {
        $credentials = request()->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            return response([
                'status' => TRUE
            ]);
        }
    }

    public function pay(Billing $billing, Transaction $transaction, Ewallet $ewallet, User $user, CreditRequest $creditRequest)
    {
        $rules = [
            'from'    => 'required',
            'amount' => 'required'
        ];

        $attributeNames = [
            'from'    => 'From',
            'amount'    => 'Amount',
        ];

        $validator = Validator::make(request()->all(), $rules);
        $validator->setAttributeNames($attributeNames);

//        $validator->after(function ($validator) use($ewallet) {
//            if ($ewallet->insufficientEwalletBalance()) {
//                $validator->errors()->add('amount', 'Insufficient Balance. Please add funds to your eWallet.');
//            }
//        });

        $validator->after(function ($validator) use($ewallet) {
            if ($ewallet->insufficientCreditBalance() && request()->from == 'available_credit') {
                $validator->errors()->add('amount', 'Insufficient Balance. Please check your available credit balance.');
            }
        });

        if ($validator->fails()) {
            return response(['errors' => TRUE,
                'messages' => $validator->errors()->all()
            ]);
        } else {
            $billing->payBilling();

            $transaction->payTransaction();

//            $ewallet->deductPayment();

            $user->where('id', auth()->user()->id)->increment('available_credit', request()->amount);

            $countBillings = $billing->where('credit_request_id', request()->credit_request_id)
                ->where('status', 'pending')
                ->count();

            session()->flash('success', 'Successfully Paid!');

            if($countBillings == 0) {
                $creditRequest->where('id', request()->credit_request_id)
                    ->update([
                        'status' => 'closed'
                    ]);
            }

            return response(['errors' => FALSE,
                'messages' => 'Success'
            ]);
        }
    }

    public function updateAvailableCredit(User $user)
    {
        $rules = [
            'merchant_id'    => 'required',
            'credit' => 'required|integer'
        ];

        $attributeNames = [
            'merchant_id'    => 'Merchant ID',
            'credit' => 'Credit'
        ];

        $validator = Validator::make(request()->all(), $rules);
        $validator->setAttributeNames($attributeNames);

        if ($validator->fails()) {
            return response(['errors' => TRUE,
                'messages' => $validator->errors()
            ]);
        } else {
            $user->where('id', request()->merchant_id)
                ->update([
                    'available_credit' => request()->credit
                ]);

            return response(['errors' => FALSE,
                'messages' => 'Success'
            ]);
        }
    }

    public function updateCurrentLoan(CreditRequest $creditRequest, Billing $billing)
    {
        $rules = [
            'lender_id'    => 'required',
            'interest_rate' => 'required',
            'amount' => 'required',
            'payment_term_id' => 'required',
//            'status' => 'required',
        ];

        $attributeNames = [
            'lender_id'    => 'Lender',
            'interest_rate' => 'Interest Rate',
            'amount' => 'Amount',
            'payment_term_id' => 'Payment Term',
//            'status' => 'Status',
        ];

        $validator = Validator::make(request()->all(), $rules);
        $validator->setAttributeNames($attributeNames);

        if ($validator->fails()) {
            return response(['errors' => TRUE,
                'messages' => $validator->errors()
            ]);
        } else {
            $creditRequest->updateCurrentLoanRequest();

//            $billing->updateCurrentLoanRequestBillings();
            session()->flash('success', 'Successfully Updated!');

            return response(['errors' => FALSE,
                'messages' => 'Success'
            ]);
        }

    }

    public function updateMobileNumber(User $user)
    {
        $user->where('id', auth()->user()->id)
            ->update([
                'mobile_number' => request()->mobile_number
            ]);

        session()->flash('success', 'Successfully Updated!');
    }

    public function readNotifs(Notification $notification)
    {
        if(auth()->user()->role_id == 4) {
            $notification->where('merchant_id', auth()->user()->id)
                ->update(['is_read' => 1]);
        } else {
            $notification->whereNull('merchant_id')
                ->update(['is_read' => 1]);
        }
    }

}
