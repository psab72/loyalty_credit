<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class CheckIfKycVerified
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
        if(auth()->user()->is_verified != 1) {
            return redirect()->back()
                ->with('error', 'You can not request a loan if you are not KYC verified.');
        }

        return $next($request);
    }
}
