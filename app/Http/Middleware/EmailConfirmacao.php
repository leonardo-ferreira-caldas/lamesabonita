<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class EmailConfirmacao
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

        if (Auth::check() && !Auth::user()->ind_email_confirmado) {
            return redirect()->route('aguardando-confirmacao-email');
        }

        return $next($request);
    }
}
