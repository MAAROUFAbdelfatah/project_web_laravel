<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class Etudiant
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        
        if(Auth::check()){

            if(Auth::user()->isEncadrant() || Auth::user()->isAdmin() || Auth::user()->isCoEncadrant()|| Auth::user()->isEtudiant()){
                return $next($request);
            }
        }
        abort(401);

    }
}