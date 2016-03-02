<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class RedirectIfAdminAuthenticated
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login');
        }

        return $next($request);
    }
}
