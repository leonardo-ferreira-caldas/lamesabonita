<?php

namespace App\Http\Middleware;

use App\Facades\Autenticacao;
use Closure;

class Chef
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

        if (Autenticacao::isLogado()) {
            if (Autenticacao::isCliente()) {
                return redirect('/minha-conta');
            }
        }

        return $next($request);
    }
}
