<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Ewallet extends Model
{
    //
    /**
     * Check if eWallet has insufficient balance
     * @return bool
     */
    public function insufficientEwalletBalance()
    {
        $eWalletData = $this->where('merchant_id', auth()->user()->id)
            ->first();

        return $eWalletData->outstanding_balance < request()->amount;
    }

    /**
     * Deduct payment from eWallet
     *
     */
    public function deductPayment()
    {
        $this->where('merchant_id', auth()->user()->id)->decrement('outstanding_balance', request()->amount);
    }

//    public function updateAvailableCredit()
//    {
//        if(!empty($this->checkMerchantWallet())) {
//            $this->where('merchant_id', request()->merchant_id)
//                ->update([
//                    'outstanding_balance' => request()->credit
//                ]);
//        } else {
//            $this->
//        }
//    }

//    public function checkMerchantWallet()
//    {
//        return $this->where('merchant_id', request()->merchant_id)
//            ->count();
//    }

    public function insufficientCreditBalance()
    {
        return auth()->user()->available_credit < request()->amount;
    }
}
