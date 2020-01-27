<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateMerchantDataRequest;
use App\Model\Billing;
use App\Model\CreditRequest;
use App\Model\Ewallet;
use App\Model\Nationality;
use App\Model\Refbrgy;
use App\Model\Refcitymun;
use App\Model\Refprovince;
use App\Model\Transaction;
use App\User;
use Illuminate\Http\Request;
use Validator;

class MerchantController extends Controller
{
    /**
     * @param Billing $billing
     * @param CreditRequest $creditRequest
     * @param Transaction $transaction
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Billing $billing, CreditRequest $creditRequest, Transaction $transaction, Ewallet $eWallet)
    {
        $billings = $billing->getBillings();

        $nextBilling = $billing->getNextBilling();

//        dd($nextBilling);

        $transactions = $transaction->getTransactions();

        $creditRequests = $creditRequest->getCreditRequests();

        $totalBills = $billing->where('status', 'pending')
            ->where('merchant_id', auth()->user()->id)
            ->sum('amount');

        $eWalletData = $eWallet->where('merchant_id', auth()->user()->id)
            ->first();

        return view('pages.dashboard.merchant', compact('billings', 'transactions', 'creditRequests', 'totalBills', 'eWalletData', 'nextBilling'));
    }

    /**
     * @param User $user
     * @param Billing $billing
     * @param Transaction $transaction
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view(User $user, Billing $billing, Transaction $transaction, CreditRequest $creditRequest, $id)
    {
        $creditRequests = $creditRequest->getAllCreditRequestsByMerchantId($id);

        $merchantData = $user->select('users.*',
            'kyc.id as kyc_id')
            ->leftJoin('kyc', 'users.id', '=', 'kyc.merchant_id')
            ->where('users.id', $id)
            ->first();

        $billings = $billing->select('billings.*')
            ->leftJoin('credit_requests', 'billings.credit_request_id', '=', 'credit_requests.id')
            ->where('credit_requests.merchant_id', $id)
            ->orderBy('billings.payment_due_date')
            ->get();

        $nextBilling = $billing->getNextBilling();

        $totalBills = $billing->where('status', 'pending')
            ->where('merchant_id', $id)
            ->sum('amount');

        $transactions = $transaction->select('transactions.*',
            'transaction_types.transaction_type_name')
            ->leftJoin('transaction_types', 'transactions.transaction_type_id', '=', 'transaction_types.id')
            ->where('merchant_id', $id)
            ->get();

        return view('pages.merchant.view', compact('merchantData', 'billings', 'transactions', 'totalBills', 'nextBilling', 'creditRequests'));
    }



    public function updatePayment(Billing $billing)
    {
        $rules = [
            'payment_due_date'    => 'required|date_format:Y-m-d',
            'amount' => 'required',
            'date_paid' => '',
            'status' => 'in:paid,pending'
        ];

        $attributeNames = [
            'payment_due_date'    => 'Payment Due Date',
            'amount' => 'Amount',
            'date_paid' => 'Date Paid',
            'status' => 'Status',
        ];

        $validator = Validator::make(request()->all(), $rules);
        $validator->setAttributeNames($attributeNames);

        if ($validator->fails()) {
            return redirect()->back();
        } else {
            $billing->where('id', request()->billing_id)
                ->update([
                    'payment_due_date' => request()->payment_due_date,
                    'amount' => request()->amount,
                    'date_paid' => request()->date_paid,
                    'status' => request()->status,
                ]);

            return redirect()->back()->with('success', 'Success');
        }
    }

    public function edit(User $user, Nationality $nationality, Refprovince $province, Refcitymun $city, Refbrgy $barangay, $id)
    {
        $merchantData = $user->select('users.*', 'countries.nicename')
            ->leftJoin('countries', 'users.country_id', '=', 'countries.id')
            ->where('users.id', $id)
            ->first();

        $nationalities = $nationality->get();

        $provinces = $province->orderBy('provDesc')
            ->get();

        $cities = $city->where('provCode', $merchantData->province_id)
            ->orderBy('citymunDesc')
            ->get();

        $cityData = $city->where('id', $merchantData->city_id)
            ->first();

        $citymunCode = !empty($cityData->citymunCode) ? $cityData->citymunCode : 0;
        $barangays = $barangay->where('citymunCode', $citymunCode)
            ->orderBy('brgyDesc')
            ->get();

        return view('pages.merchant.edit', compact('merchantData', 'nationalities', 'provinces', 'cities', 'barangays'));
    }

    /**
     * @param User $user
     */
    public function update(UpdateMerchantDataRequest $updateMerchantDataRequest, User $user)
    {
        $data = [];
        !empty(request()->first_name) ? $data['first_name'] = request()->first_name : '';
        !empty(request()->middle_name) ? $data['middle_name'] = request()->middle_name : '';
        !empty(request()->last_name) ? $data['last_name'] = request()->last_name : '';
        !empty(request()->email) ? $data['email'] = request()->email : '';
        !empty(request()->date_of_birth) ? $data['date_of_birth'] = request()->date_of_birth : '';
        !empty(request()->place_of_birth) ? $data['place_of_birth'] = request()->place_of_birth : '';
        !empty(request()->house_no) ? $data['house_no'] = request()->house_no : '';
        !empty(request()->brgy_id) ? $data['brgy_id'] = request()->brgy_id : '';
        !empty(request()->city_id) ? $data['city_id'] = request()->city_id : '';
        !empty(request()->province_id) ? $data['province_id'] = request()->province_id : '';
        !empty(request()->nationality_id) ? $data['nationality_id'] = request()->nationality_id : '';
        !empty(request()->mobile_number) ? $data['mobile_number'] = request()->mobile_number : '';
        !empty(request()->establishment_name) ? $data['establishment_name'] = request()->establishment_name : '';
        !empty(request()->source_of_income) ? $data['source_of_income'] = request()->source_of_income : '';

        $user->where('id', request()->merchant_id)
            ->update($data);

        session()->flash('success', 'Successfully Updated!');

        return redirect()->back();
    }
}
