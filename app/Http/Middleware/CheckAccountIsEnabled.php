<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

/**
 * Make sure user account is enabled.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class CheckAccountIsEnabled {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if (Auth::check() && Auth::user()->disabled) {
            Auth::logout();
            return redirect('/');
        }
        return $next($request);
    }
}
