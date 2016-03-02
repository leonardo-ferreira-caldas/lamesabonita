<?php

namespace App\Http\Middleware;

use Closure;
use App\Facades\Autenticacao;

class RedirectIfAuthenticated
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
            if (Autenticacao::isChef()) {
                return redirect()->route('chef.visao_geral');
            }

            return redirect()->route('cliente.pagina_inicial');
        }

        return $next($request);
    }
}
