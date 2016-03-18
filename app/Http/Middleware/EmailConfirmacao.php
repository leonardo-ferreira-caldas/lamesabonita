<?php

namespace App\Http\Middleware;

use App\Facades\Autenticacao;
use Closure;

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
        if (Autenticacao::isLogado() && !Autenticacao::isEmailConfirmado()) {
            return redirect()->route('aguardando-confirmacao-email');
        }

        return $next($request);
    }
}
