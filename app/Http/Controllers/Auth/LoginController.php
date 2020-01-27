<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    protected function authenticated($user)
    {
        if ($this->userData()->role_id == config('constants.roles.admin')) {// do your magic here
            return redirect()->route('dashboard-admin');
        }

        if ($this->userData()->role_id == config('constants.roles.agent')) {// do your magic here
            return redirect()->route('dashboard-agent');
        }

        if ($this->userData()->role_id == config('constants.roles.merchant')) {// do your magic here
            return redirect()->route('dashboard-merchant');
        }

        return redirect('/home');
    }

    protected function userData()
    {
        return Auth::user();
    }



    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * @param Request $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        if(is_numeric($request->get('email'))){
            return ['mobile_number'=>$request->get('email'),'password'=>$request->get('password')];
        }
        return $request->only($this->username(), 'password');
    }
}
