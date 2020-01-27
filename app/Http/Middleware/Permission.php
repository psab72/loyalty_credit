<?php

namespace App\Http\Middleware;

use Closure;

class Permission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $adminModules = [
            'dashboard-admin',
            'dashboard-merchants',
            'sales-data',
            'kyc-data',
            'update-kyc',
            'kyc-assign',
            'kyc',
            'loan-requests',
            'merchant',
            'compute-amortization',
            'update-loan-request',
            'step-one-register',
            'update-available-credit',
            'update-payment',
            'update-current-loan',
            'read-notifs',
            'edit-merchant',
            'update-merchant',
            'users',
            'user',
            'update-user',
        ];

        $superUserModules = [
            'dashboard-super-user',
            'sales-data',
            'loan-requests',
            'merchant',
        ];

        $agentModules = [
            'dashboard-agent',
            'sales-data',
            'loan-requests',
            'merchant',
        ];

        $merchantModule = [
            'dashboard-merchant',
            'upload-kyc',
            'kyc',
            'credit-request',
            'compute-amortization',
            'pay',
            'notification',
            'update-mobile-number',
            'read-notifs',
            'update-user',
            'user',
        ];

        if(auth()->user()->role_id == config('constants.roles.merchant') && !in_array(request()->segment(1), $merchantModule)) {
            return redirect('not-permitted');
        } elseif(auth()->user()->role_id == config('constants.roles.agent') && !in_array(request()->segment(1), $agentModules)) {
            return redirect('not-permitted');
        } elseif(auth()->user()->role_id == config('constants.roles.super_user') && !in_array(request()->segment(1), $superUserModules)) {
            return redirect('not-permitted');
        } elseif(auth()->user()->role_id == config('constants.roles.admin') && !in_array(request()->segment(1), $adminModules)) {
            return redirect('not-permitted');
        }
        return $next($request);
    }
}
