<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use DB;
use App\User;

class Billing extends Model
{
    public $timestamps = FALSE;
    //
    public function getBillings()
    {
        return $this->select('billings.*',
            'credit_requests.merchant_id')
            ->leftJoin('credit_requests', 'billings.credit_request_id', '=', 'credit_requests.id')
            ->where('credit_requests.merchant_id', auth()->user()->id)
            ->orderBy('payment_due_date')
            ->get();
    }
    /**
     * Get Upcoming Billings
     *
     * @return mixed
     */
    public function upcomingBillings()
    {
        return $this->select('billings.id',
            'billings.amount',
            'billings.payment_due_date',
            'billings.status',
            'users.id as user_id',
            'users.first_name',
            'users.last_name')
            ->leftJoin('credit_requests', 'billings.credit_request_id', '=', 'credit_requests.id')
            ->leftJoin('users', 'credit_requests.merchant_id', '=', 'users.id')
//            ->where('billings.payment_due_date', '>', date('Y-m-d'))
            ->where('billings.status', '=', 'pending')
            ->orderBy('billings.payment_due_date')
            ->get();
    }

    /**
     * Get Total Late Bills
     *
     * @return float|int
     */
    public function totalLateBills()
    {
        $request = request();

        $totalLateBills = $this->where('payment_due_date', '<', date('Y-m-d'))
            ->when(!empty(request()->from) && !empty(request()->to), function($query) use($request) {
                return $query->whereBetween('date_transacted', [$request->from, $request->to]);
            })
            ->where('status', 'pending')
            ->pluck('amount')
            ->toArray();

        return array_sum($totalLateBills);
    }

    /**
     * Get Total Repaid Records
     *
     * @return float|int
     */
    public function totalRepaid()
    {
        $request = request();
        $totalRepaid = $this->where('status', 'paid')
            ->when(!empty(request()->from) && !empty(request()->to), function($query) use($request) {
                return $query->whereBetween('date_transacted', [$request->from, $request->to]);
            })
            ->pluck('amount')
            ->toArray();

        return array_sum($totalRepaid);
    }

    /**
     * Get total defaulters
     *
     * @return mixed
     */
    public function totalDefaulters()
    {
        return $this->where('status', 'pending')
            ->where('payment_due_date', '<', date('Y-m-d'))
            ->groupBy('credit_request_id')
            ->count();
    }

    /**
     * Get late bills per month
     *
     * @return mixed
     */
    public function lateBillsPerMonthWithRange()
    {
        return DB::select('SELECT DATE_FORMAT(payment_due_date, \'%b %y\') as month, 
          SUM(amount) as amount
          FROM billings 
          WHERE ' . $this->whereBetweenParams() . ' AND (payment_due_date < date_paid AND status = \'paid\') OR (payment_due_date IS NULL AND status = \'pending\')
          GROUP BY DATE_FORMAT(payment_due_date, \'%b %y\') 
          ORDER BY payment_due_date');
    }

    /**
     * Get repaid bills per month
     *
     * @return mixed
     */
    public function repaidPerMonthWithRange()
    {
        return DB::select('SELECT DATE_FORMAT(date_paid, \'%b %y\') as month, 
          SUM(amount) as amount
          FROM billings 
          WHERE ' . $this->whereBetweenParams() . ' AND status = \'paid\'
          GROUP BY DATE_FORMAT(date_paid, \'%b %y\') 
          ORDER BY date_paid');
    }

    /**
     * Get where between params
     *
     * @return string
     */
    public function whereBetweenParams()
    {
        return !empty(request()->from) && !empty(request()->to) ? 'payment_due_date BETWEEN \'' . request()->from . '\' AND LAST_DAY(\'' . request()->to . '\')' : '';

    }

    /**
     * Get Next Billing Record
     *
     * @return mixed
     */
    public function getNextBilling()
    {

        return $this->where('billings.merchant_id', auth()->user()->id)
            ->where('billings.status', '=', 'pending')
            ->whereNull('date_paid')
            ->orderBy('billings.payment_due_date')
            ->first();
    }

    public function payBilling()
    {
        $this->where('id', request()->billing_id)
            ->update([
                'status' => 'paid',
                'date_paid' => date('Y-m-d')
            ]);
    }

    public function updateCurrentLoanRequestBillings()
    {
        $remainingAmount = $this->where('credit_request_id', request()->credit_request_id)
            ->where('status', 'pending')
            ->sum('amount');

        $this->where('credit_request_id', request()->credit_request_id)
            ->where('status', 'pending')
            ->update([
                'is_deleted', 1
            ]);

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

        $this->insert($billings);





    }
}
