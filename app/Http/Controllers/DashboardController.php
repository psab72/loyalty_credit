<?php

namespace App\Http\Controllers;

use App\Model\Billing;
use App\Model\CreditRequest;
use Illuminate\Http\Request;
use App\Model\Transaction;
use View;

class DashboardController extends Controller
{
    //
    /**
     * @param Transaction $transaction
     * @param Billing $billing
     * @return View
     */
    public function admin(Transaction $transaction, Billing $billing, CreditRequest $creditRequest)
    {
        $totalAmountLent = number_format($transaction->totalAmountLent(), 2, '.', ',');

        $totalAmountAtRisk = number_format($transaction->totalAmountAtRisk(), 2, '.', ',');

        $totalLateBills = number_format($billing->totalLateBills(), 2, '.', ',');

        $totalRepaid = number_format($billing->totalRepaid(), 2, '.', ',');

        $latestTransactions = $transaction->latestTransactions();

        $upcomingBillings = $billing->upcomingBillings();

        $dataPerMonth = $creditRequest->amountLentPerMonthWithRange();

        $interestCharged = $creditRequest->whereIn('status', ['accepted', 'closed'])
            ->sum('interest_amount');

        $months = $this->months();

        return view('pages.dashboard.admin', compact(
            'totalAmountLent',
            'totalAmountAtRisk',
            'latestTransactions',
            'upcomingBillings',
            'totalLateBills',
            'totalRepaid',
            'dataPerMonth',
            'interestCharged',
            'months'));
    }

    public function superUser()
    {
        return view('pages.dashboard.super-user');
    }

    public function agent()
    {
        return view('pages.dashboard.agent');
    }

    public function months()
    {
        $months = [];
        for ($i = 0; $i < 12; $i++) {
            $timestamp = mktime(0, 0, 0, date('n') - $i, 1);
            $months[date('n', $timestamp)] = date('F', $timestamp);
        }

        ksort($months);

        return $months;
    }
}
