<?php

namespace App\Model;

use App\Model\Ewallet;
use App\User;
use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;
use App\Model\Transaction;
use Illuminate\Support\Facades\Mail;

class CreditRequest extends Model
{
    //
    /** Get total count of Transactors
     * @return mixed
     */
    public function totalTransactors()
    {
        return $this->distinct()
            ->count();
    }

    /** Get total count of Revolvers
     * @return mixed
     */
    public function totalRevolvers()
    {
        return $this->where('status', 'accepted')
            ->groupBy('merchant_id')
            ->count();
    }

    /** Get total sum of financed per month
     * @return mixed
     */
    public function amountLentPerMonthWithRange()
    {
        return DB::select('SELECT DATE_FORMAT(date_accepted, \'%b %y\') as month, 
          SUM(amount) as amount 
          FROM credit_requests 
          WHERE ' . $this->whereBetweenParams() . ' status = \'accepted\' 
          GROUP BY DATE_FORMAT(date_accepted, \'%b %y\') 
          ORDER BY date_accepted');
    }

    /** Get where between params
     * @return string
     */
    public function whereBetweenParams()
    {
        return !empty(request()->from) && !empty(request()->to) ? 'date_accepted BETWEEN \'' . request()->from . '\' AND LAST_DAY(\'' . request()->to . '\') AND' : '';

    }

    /**
     * @return mixed
     */
    public function getCreditRequests()
    {
        return $this->select('credit_requests.*',
            'payment_terms.payment_term_name',
            'lenders.lender_name',
            'users.establishment_name',
            DB::raw('(CASE 
                WHEN status = \'processing\' THEN \'info\'
                WHEN status = \'on_hold\' THEN \'warning\'
                WHEN status = \'closed\' THEN \'default\'
                WHEN status = \'rejected\' THEN \'danger\'
                WHEN status = \'accepted\' THEN \'success\'
            END) AS bootstrap_badge_contextual_class'),
            DB::raw('(CASE 
                WHEN status = \'processing\' THEN \'Processing\'
                WHEN status = \'on_hold\' THEN \'On Hold\'
                WHEN status = \'closed\' THEN \'Closed\'
                WHEN status = \'rejected\' THEN \'Rejected\'
                WHEN status = \'accepted\' THEN \'Accepted\'
                ELSE \'\'
            END) AS status_name'),
            DB::raw('CONCAT(users.first_name, \' \', users.last_name) as merchant_name'))
            ->leftJoin('payment_terms', 'credit_requests.payment_term_id', '=', 'payment_terms.id')
            ->leftJoin('users', 'credit_requests.merchant_id', '=', 'users.id')
            ->leftJoin('lenders', 'credit_requests.lender_id', '=', 'lenders.id')
            ->where('credit_requests.merchant_id', auth()->user()->id)
            ->get();
    }

    /**
     * @return mixed
     */
    public function getAllCreditRequests()
    {
        return $this->select('credit_requests.*',
            'payment_terms.id as payment_term_id',
            'payment_terms.payment_term_name',
            'lenders.lender_name',
            'users.establishment_name',
            'users.email',
            'kyc.id as kyc_id',
            DB::raw('(CASE 
                WHEN credit_requests.status = \'processing\' THEN \'badge-info\'
                WHEN credit_requests.status = \'on_hold\' THEN \'badge-warning\'
                WHEN credit_requests.status = \'closed\' THEN \'badge-primary\'
                WHEN credit_requests.status = \'rejected\' THEN \'badge-danger\'
                WHEN credit_requests.status = \'accepted\' THEN \'badge-success\'
                ELSE \'badge-secondary\'
            END) AS bootstrap_status_text_color_class'),
            DB::raw('CONCAT(users.first_name, \' \', users.last_name) as merchant_name'))
            ->leftJoin('payment_terms', 'credit_requests.payment_term_id', '=', 'payment_terms.id')
            ->leftJoin('users', 'credit_requests.merchant_id', '=', 'users.id')
            ->leftJoin('kyc', 'users.id', '=', 'kyc.merchant_id')
            ->leftJoin('lenders', 'credit_requests.lender_id', '=', 'lenders.id')
            ->get();
    }

    public function getNewCreditRequests()
    {
        return $this->select('credit_requests.*',
            'payment_terms.id as payment_term_id',
            'payment_terms.payment_term_name',
            'lenders.lender_name',
            'users.establishment_name',
            'users.email',
            'kyc.id as kyc_id',
            DB::raw('(CASE 
                WHEN credit_requests.status = \'processing\' THEN \'badge-info\'
                WHEN credit_requests.status = \'on_hold\' THEN \'badge-warning\'
                WHEN credit_requests.status = \'closed\' THEN \'badge-primary\'
                WHEN credit_requests.status = \'rejected\' THEN \'badge-danger\'
                WHEN credit_requests.status = \'accepted\' THEN \'badge-success\'
                ELSE \'badge-secondary\'
            END) AS bootstrap_status_text_color_class'),
            DB::raw('(CASE 
                WHEN credit_requests.status = \'processing\' THEN \'Processing\'
                WHEN credit_requests.status = \'on_hold\' THEN \'On Hold\'
                WHEN credit_requests.status = \'closed\' THEN \'Closed\'
                WHEN credit_requests.status = \'rejected\' THEN \'Rejected\'
                WHEN credit_requests.status = \'accepted\' THEN \'Accepted\'
                ELSE \'badge-secondary\'
            END) AS status_name'),
            DB::raw('CONCAT(users.first_name, \' \', users.last_name) as merchant_name'))
            ->leftJoin('payment_terms', 'credit_requests.payment_term_id', '=', 'payment_terms.id')
            ->leftJoin('users', 'credit_requests.merchant_id', '=', 'users.id')
            ->leftJoin('kyc', 'users.id', '=', 'kyc.merchant_id')
            ->leftJoin('lenders', 'credit_requests.lender_id', '=', 'lenders.id')
            ->where('credit_requests.status', 'processing')
            ->get();
    }

    public function getCurrentCreditRequests()
    {
        return $this->select('credit_requests.*',
            'payment_terms.id as payment_term_id',
            'payment_terms.payment_term_name',
            'lenders.lender_name',
            'users.establishment_name',
            'users.email',
            'kyc.id as kyc_id',
            DB::raw('(CASE 
                WHEN credit_requests.status = \'processing\' THEN \'badge-info\'
                WHEN credit_requests.status = \'on_hold\' THEN \'badge-warning\'
                WHEN credit_requests.status = \'closed\' THEN \'badge-primary\'
                WHEN credit_requests.status = \'rejected\' THEN \'badge-danger\'
                WHEN credit_requests.status = \'accepted\' THEN \'badge-success\'
                ELSE \'badge-secondary\'
            END) AS bootstrap_status_text_color_class'),
            DB::raw('CONCAT(users.first_name, \' \', users.last_name) as merchant_name'))
            ->leftJoin('payment_terms', 'credit_requests.payment_term_id', '=', 'payment_terms.id')
            ->leftJoin('users', 'credit_requests.merchant_id', '=', 'users.id')
            ->leftJoin('kyc', 'users.id', '=', 'kyc.merchant_id')
            ->leftJoin('lenders', 'credit_requests.lender_id', '=', 'lenders.id')
            ->where('credit_requests.status', '!=', 'processing')
            ->get();
    }

    /**
     * Get credit requests of merchant
     *
     * @return mixed
     */
    public function getAllCreditRequestsByMerchantId($id = 0)
    {
        return $this->select('credit_requests.*',
            'payment_terms.id as payment_term_id',
            'payment_terms.payment_term_name',
            'lenders.lender_name',
            'users.establishment_name',
            'users.email',
            'kyc.id as kyc_id',
            DB::raw('(CASE 
                WHEN credit_requests.status = \'processing\' THEN \'badge-info\'
                WHEN credit_requests.status = \'on_hold\' THEN \'badge-warning\'
                WHEN credit_requests.status = \'closed\' THEN \'badge-primary\'
                WHEN credit_requests.status = \'rejected\' THEN \'badge-danger\'
                WHEN credit_requests.status = \'accepted\' THEN \'badge-success\'
                ELSE \'badge-secondary\'
            END) AS bootstrap_status_text_color_class'),
            DB::raw('(CASE 
                WHEN credit_requests.status = \'processing\' THEN \'Processing\'
                WHEN credit_requests.status = \'on_hold\' THEN \'On Hold\'
                WHEN credit_requests.status = \'closed\' THEN \'Closed\'
                WHEN credit_requests.status = \'rejected\' THEN \'Rejected\'
                WHEN credit_requests.status = \'accepted\' THEN \'Accepted\'
                ELSE \'badge-secondary\'
            END) AS status_name'),
            DB::raw('CONCAT(users.first_name, \' \', users.last_name) as merchant_name'))
            ->leftJoin('payment_terms', 'credit_requests.payment_term_id', '=', 'payment_terms.id')
            ->leftJoin('users', 'credit_requests.merchant_id', '=', 'users.id')
            ->leftJoin('kyc', 'users.id', '=', 'kyc.merchant_id')
            ->leftJoin('lenders', 'credit_requests.lender_id', '=', 'lenders.id')
            ->where('credit_requests.merchant_id', $id)
            ->get();
    }

    public function updateLoanRequest()
    {
        try {
            DB::beginTransaction();


            $loanRequestData = $this->where('id', request()->credit_request_id)
                ->first();
            if(request()->status == 'accepted') {
                $this->where('id', request()->credit_request_id)
                    ->update([
                        'lender_id' => request()->lender_id,
                        'interest_rate' => request()->interest_rate,
                        'interest_amount' => request()->interest_amount,
                        'amount' => request()->amount,
                        'monthly_amortization' => request()->monthly_amortization,
                        'payment_term_id' => request()->payment_term_id,
                        'hold_reason_id' => request()->hold_reason_id,
                        'reject_reason_id' => request()->reject_reason_id,
                        'comment' => request()->comment,
                        'status' => request()->status
                    ]);
            } elseif(request()->status == 'on_hold' || request()->status == 'rejected') {
                $this->where('id', request()->credit_request_id)
                    ->update([
                        'hold_reason_id' => request()->hold_reason_id,
                        'reject_reason_id' => request()->reject_reason_id,
                        'comment' => request()->comment,
                        'status' => request()->status
                    ]);

                Notification::insert([
                    'merchant_id' => $loanRequestData->merchant_id,
                    'message' => request()->status == 'on_hold' ? 'Your loan was held.' : 'Your loan was rejected'
                ]);
            }

            if(request()->status == 'accepted') {
//                $lenderData = Lender::where('id', request()->lender_id)
//                    ->first();

//                $interestAmount = number_format((float) request()->amount * (request()->interest_rate / 100), 2, '.', '');

                $this->loanAccepted();

//                $this->insertUpdateEwallet($interestAmount);

                $this->createInitTransaction();

                Notification::insert([
                    'merchant_id' => $loanRequestData->merchant_id,
                    'message' => 'Your loan was accepted.'
                ]);
            }

            DB::commit();
        } catch(\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
//            return FALSE;
        }

        $this->sendMail();

    }

    public function loanAccepted()
    {
        $paymentTermData = PaymentTerm::where('id', request()->payment_term_id)
            ->first();

        $billings = [];
        for($i=1;$i<=$paymentTermData->no_of_months;$i++) {
            $billings[] = [
                'credit_request_id' => request()->credit_request_id,
                'merchant_id' => request()->merchant_id,
                'payment_due_date' => Carbon::now()->addMonths($i),
                'amount' => request()->monthly_amortization,
            ];
        }

        Billing::insert($billings);

        User::where('id', request()->merchant_id)->decrement('available_credit', request()->amount);
    }

    /**
     *
     */
    public function insertUpdateEwallet($interestAmount)
    {
        $eWallet = Ewallet::where('merchant_id', request()->merchant_id)
            ->count();

        if(!empty($eWallet)) {
            $this->updateEwallet($interestAmount);
        } else {
            $this->createEwallet($interestAmount);
        }
    }

    /**
     *
     */
    public function createEwallet($interestAmount)
    {
        Ewallet::insert([
            'merchant_id' => request()->merchant_id,
            'outstanding_balance' => (PaymentTerm::where('id', request()->payment_term_id)->first()->no_of_months * request()->monthly_amortization) - $interestAmount,
        ]);
    }

    /**
     *
     */
    public function updateEwallet($interestAmount)
    {
        $eWallet = Ewallet::where('merchant_id', request()->merchant_id)
            ->first();

        Ewallet::where('merchant_id', request()->merchant_id)
            ->update([
                'outstanding_balance' => $eWallet->outstanding_balance + (PaymentTerm::where('id', request()->payment_term_id)->first()->no_of_months * request()->monthly_amortization) - $interestAmount,
            ]);
    }

    /**
     *
     */
    public function createInitTransaction()
    {
        Transaction::insert([
            'credit_request_id' => request()->credit_request_id,
            'transaction_type_id' => 1,
            'lender_id' => request()->lender_id,
            'merchant_id' => request()->merchant_id,
            'amount' => request()->amount,
            'date_transacted' => date('Y-m-d')
        ]);

    }



    /**
     *
     */
    public function sendMail()
    {
        $request = request()->toArray();

        $rejectReason = !empty(LoanRequestsRejectReason::where('id', request()->reason_id)->first()) ? LoanRequestsRejectReason::where('id', request()->reason_id)->first() : '';
        $holdReason = !empty(LoanRequestsHoldReason::where('id', request()->reason_id)->first()) ? LoanRequestsHoldReason::where('id', request()->reason_id)->first() : '';

        $reason = request()->status == 'rejected' ? $rejectReason : $holdReason;
        $request['reason'] = $reason;

        Mail::send('emails.' . config('constants.email_template_loan_update')[request()->status]['file'], $request, function($message) use ($request) {
            $message->to(request()->merchant_email, request()->merchant_name)
                ->subject(config('constants.email_template_loan_update')[request()->status]['subject']);
            $message->from('support@loyaltycredit', 'Loyalty Credit Web');
        });

        if(request()->status == 'accepted') {
            Notification::insert([
                'merchant_id' => auth()->user()->id,
                'message' =>  'Hi ' . auth()->user()->first_name . ' ' . auth()->user()->last_name . '<br /><br />Your loan was accepted.'
            ]);
        } elseif(request()->status == 'rejected') {
            Notification::insert([
                'merchant_id' => auth()->user()->id,
                'message' =>  'Your loan was rejected,'
            ]);
        } elseif(request()->status == 'on_hold') {
            Notification::insert([
                'merchant_id' => auth()->user()->id,
                'message' =>  'Your loan was held.'
            ]);
        }
    }

    public function updateCurrentLoanRequest()
    {
        $this->where('id', request()->credit_request_id)
            ->update([
                'lender_id'    => request()->lender_id,
                'interest_rate' => request()->interest_rate,
                'interest_amount' => request()->interest_amount,
                'amount' => request()->amount,
                'payment_term_id' => request()->payment_term_id,
                'monthly_amortization' => request()->monthly_amortization,
//                'status' => request()->status,
            ]);
    }

}
