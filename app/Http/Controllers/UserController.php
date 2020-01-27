<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Model\Billing;
use App\Model\CreditRequest;
use App\Model\Kyc;
use Illuminate\Http\Request;
use App\User;
use DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    public function index(User $user, CreditRequest $creditRequest, Billing $billing, Kyc $kyc)
    {
        $totalMerchants = $user->totalMerchants();

        $users = $user->getUsers();

        $percentageDifferenceTotalMerchantsLastMonth = $user->percentageDifferenceTotalMerchantsLastMonth();

        $merchants = $user->getMerchants();

        $totalTransactors = $creditRequest->totalTransactors();

        $totalRevolvers = $creditRequest->totalRevolvers();

        $totalDefaulters = $billing->totalDefaulters();

        $kycData = $kyc->kycData();

        return view('pages/user/index', compact('totalMerchants',
            'merchants',
            'totalTransactors',
            'totalRevolvers',
            'totalDefaulters',
            'percentageDifferenceTotalMerchantsLastMonth',
            'kycData',
            'users'));
    }

    public function users(CreditRequest $creditRequest, Billing $billing, User $user)
    {
        $users = $user->select('users.*',
            'roles.role')
            ->leftJoin('roles', 'users.role_id', '=', 'roles.id')
            ->get();
        $percentageDifferenceTotalMerchantsLastMonth = $user->percentageDifferenceTotalMerchantsLastMonth();

        $totalMerchants = $user->totalMerchants();

        $totalTransactors = $creditRequest->totalTransactors();

        $totalRevolvers = $creditRequest->totalRevolvers();

        $totalDefaulters = $billing->totalDefaulters();

        return view('pages.user.index-users', compact('totalTransactors',
            'totalMerchants',
            'totalRevolvers',
            'percentageDifferenceTotalMerchantsLastMonth',
            'totalDefaulters',
            'users'));
    }

    public function user(User $user, $id = 0)
    {
        $userData = $user->where('id', $id)
            ->first();

        return view('pages.user.edit', compact('userData'));
    }

    public function update(UpdateUserRequest $updateUserRequest, User $user)
    {
        $user->where('id', request()->id)
            ->update([
//                'first_name' => request()->first_name,
//                'middle_name' => request()->middle_name,
//                'last_name' => request()->last_name,
//                'email' => request()->email,
                'password' => Hash::make(request()->password),
            ]);

        return redirect()->to('users')->with('success', 'Password updated!');
    }
}

