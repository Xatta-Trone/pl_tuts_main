<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ForceLogoutUserIfNotAuthenticated
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

        if (Auth::guard('admin')->check()) {
            if (Auth::guard('admin')->user()->status == 0) {
                Auth::guard('admin')->logout();
                return redirect(route('admin.login'))->withErrors(['password'=>'Your account is not active . Please contact admin.']);
            }
        }elseif (Auth::guard('web')->check()) {
            if (Auth::guard('web')->user()->status == 0) {
                Auth::guard('web')->logout();
                return redirect(route('login'))->withErrors(['password'=>'Your account is not active . Please contact admin.']);
            }
        }
        return $next($request);
    }
}
