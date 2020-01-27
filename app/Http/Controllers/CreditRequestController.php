<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreditRequestPostRequest;
use App\Model\CreditRequest;
use App\Model\Lender;
use App\Model\LoanRequestsHoldReason;
use App\Model\LoanRequestsRejectReason;
use App\Model\Notification;
use App\Model\PaymentTerm;
use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class CreditRequestController extends Controller
{
    //
    public function index(PaymentTerm $paymentTerm, Lender $lender)
    {
        $lenders = $lender->where('country_id', auth()->user()->country_id)
            ->get();

        $paymentTerms = $paymentTerm->get();

        return view('pages.merchant.credit-request', compact('paymentTerms', 'lenders'));
    }

    /**
     * @param CreditRequestPostRequest $creditRequestPostRequest
     * @param CreditRequest $creditRequest
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postLoanRequest(CreditRequestPostRequest $creditRequestPostRequest, CreditRequest $creditRequest, Notification $notification, PaymentTerm $paymentTerm, User $user)
    {
        try {
            $paymentTermData = $paymentTerm->where('id', request()->payment_term_id)
                ->first();

            $amountRequest = (float) request()->amount;
            $interestRate = (float) request()->interest_rate * 0.01;
            $noOfMonths = $paymentTermData->no_of_months;

            $interestAmount = $amountRequest * $interestRate * $noOfMonths;
            $interestAmount = number_format($interestAmount, 2, '.', '');

            $totalAmount = ($amountRequest + $interestAmount);
            $monthlyAmortization = $totalAmount / $paymentTermData->no_of_months;

            $creditRequest->lender_id = request()->lender_id;
            $creditRequest->interest_rate = request()->interest_rate;
            $creditRequest->interest_amount = $interestAmount;
            $creditRequest->amount = request()->amount;
            $creditRequest->monthly_amortization = $monthlyAmortization;
            $creditRequest->payment_term_id = request()->payment_term_id;
            $creditRequest->merchant_id = auth()->user()->id;
            $creditRequest->date_requested = date('Y-m-d');
            $creditRequest->save();

            $notification->insert([
                'lender_id' => request()->lender_id,
                'message' => 'New loan request by merchant ' . auth()->user()->first_name . ' ' . auth()->user()->last_name
            ]);

            return redirect()->to('dashboard-merchant')
                ->with('success', 'Loan Request submitted. Please wait for the confirmation of the team.');

        } catch(\Exception $e) {
            dd($e->getMessage());
        }
    }

    /**
     * @param CreditRequest $creditRequest
     * @param LoanRequestsRejectReason $loanRequestsRejectReason
     * @param LoanRequestsHoldReason $loanRequestsHoldReason
     * @param Lender $lender
     * @param PaymentTerm $paymentTerm
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function loanRequests(CreditRequest $creditRequest, LoanRequestsRejectReason $loanRequestsRejectReason, LoanRequestsHoldReason $loanRequestsHoldReason, Lender $lender, PaymentTerm $paymentTerm)
    {
        $creditRequests = $creditRequest->getAllCreditRequests();

        $newCreditRequests = $creditRequest->getNewCreditRequests();
        $currentCreditRequests = $creditRequest->getCurrentCreditRequests();

        $loanRequestsRejectReasons = $loanRequestsRejectReason->get();
        $loanRequestsHoldReasons = $loanRequestsHoldReason->get();

        $lenders = $lender->where('country_id', auth()->user()->country_id)
            ->get();

//        dd(auth()->user()->country_id);

        $paymentTerms = $paymentTerm->get();

        return view('pages.loan.loan-requests', compact('creditRequests', 'newCreditRequests', 'currentCreditRequests', 'loanRequestsRejectReasons', 'loanRequestsHoldReasons', 'paymentTerms', 'lenders'));
    }

    /**
     * @param CreditRequest $creditRequest
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateLoanRequest(CreditRequest $creditRequest)
    {
        $creditRequest->updateLoanRequest();

        return redirect()->back()
            ->with('success', 'Loan Updated!');
    }
}
