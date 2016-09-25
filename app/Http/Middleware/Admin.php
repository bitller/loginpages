<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

/**
 * Check if user is admin.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class Admin {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if (!Auth::user()->hasRole('admin')) {
            return redirect('/');
        }
        return $next($request);
    }
}
