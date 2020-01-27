<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            if(auth()->user()->role_id == config('constants.roles.merchant')) {
                return redirect('/dashboard-merchant'); //temporary
            } elseif(auth()->user()->role_id == config('constants.roles.super_user')) {
                return redirect('dashboard-super-user');
            } elseif(auth()->user()->role_id == config('constants.roles.admin')) {
                return redirect('dashboard-admin');
            }
        }

        return $next($request);
    }
}
