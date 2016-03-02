<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Auth;

class Chef
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   

        if ($this->auth->check()) {
            if($this->auth->user()->ind_admin) {
                return redirect(env('WEBSITE_URL') . DIRECTORY_SEPARATOR . env('ADMIN_PATH  '));
            } else if(!$this->auth->user()->ind_chef) {
                return redirect('/minha-conta');
            }
        }

        return $next($request);
    }
}
