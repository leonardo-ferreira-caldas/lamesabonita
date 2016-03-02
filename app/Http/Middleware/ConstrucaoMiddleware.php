<?php

namespace App\Http\Middleware;

use Closure;

class ConstrucaoMiddleware
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

        $cookie = $request->cookie('development');

        if (empty($cookie) || $cookie != 'development') {
            return redirect('/construcao');
        }

        return $next($request);
    }
}
