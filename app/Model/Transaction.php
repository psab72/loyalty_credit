<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use DB;

class Transaction extends Model
{
    //
    public function getTransactions()
    {
        return $this->select('transactions.*',
            'transaction_types.transaction_type_name')
            ->leftJoin('transaction_types', 'transactions.transaction_type_id', '=', 'transaction_types.id')
            ->where('merchant_id', auth()->user()->id)
            ->get();
    }
    /**
     * @return float|int
     */
    public function totalAmountLent()
    {
        $request = request();

        $totalAmountLent = $this->where('transaction_type_id', 1)
            ->when(!empty(request()->from) && !empty(request()->to), function($query) use($request) {
                return $query->whereBetween('date_transacted', [$request->from, $request->to]);
            })
            ->pluck('amount')
            ->toArray();

        return array_sum($totalAmountLent);
    }

    /**
     * @return float|int
     */
    public function totalAmountRepaid()
    {
        $request = request();

        $totalAmountRepaid = $this->where('transaction_type_id', 2)
            ->when(!empty(request()->from) && !empty(request()->to), function($query) use($request) {
                return $query->whereBetween('date_transacted', [$request->from, $request->to]);
            })
            ->pluck('amount')
            ->toArray();

        return array_sum($totalAmountRepaid);
    }

    /**
     * @return float|int
     */
    public function totalAmountAtRisk()
    {
        $totalAmountAtRisk = $this->totalAmountLent() - $this->totalAmountRepaid();
        return $totalAmountAtRisk >= 0 ? $totalAmountAtRisk : 0.00 ;
    }

    /**
     * @return mixed
     */
    public function latestTransactions()
    {
        return $this->select('transactions.date_transacted',
            'transactions.amount',
            'users.id as merchant_id',
            'users.first_name',
            'users.last_name',
            'transaction_types.transaction_type_name')
            ->leftJoin('credit_requests', 'transactions.credit_request_id', '=', 'credit_requests.id')
            ->leftJoin('users', 'credit_requests.merchant_id', '=', 'users.id')
            ->leftJoin('transaction_types', 'transactions.transaction_type_id', '=', 'transaction_types.id')
            ->orderBy('transactions.date_transacted', 'desc')
            ->get();
    }

    /** Get Amount At Risk Per Month
     * @return mixed
     */
    public function amountAtRiskPerMonthWithRange()
    {
        return DB::select('SELECT DATE_FORMAT(date_transacted, \'%b %y\') as month, 
          SUM(amount) as amount,
          IF(transaction_type_id = 2, SUM(amount), 0) as repaid
          FROM transactions 
          WHERE ' . $this->whereBetweenParams() . ' 
          GROUP BY DATE_FORMAT(date_transacted, \'%b %y\') 
          ORDER BY date_transacted');
    }

    /** Get where between params
     * @return string
     */
    public function whereBetweenParams()
    {
        return !empty(request()->from) && !empty(request()->to) ? 'date_transacted BETWEEN \'' . request()->from . '\' AND LAST_DAY(\'' . request()->to . '\')' : '';

    }

    public function payTransaction()
    {
        $this->insert([
            'credit_request_id' => request()->credit_request_id,
            'transaction_type_id' => 2,
            'lender_id' => request()->lender_id,
            'merchant_id' => auth()->user()->id,
            'amount' => request()->amount,
            'date_transacted' => date('Y-m-d')
        ]);
    }
}
