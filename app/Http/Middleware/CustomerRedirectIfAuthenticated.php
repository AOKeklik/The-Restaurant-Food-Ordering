<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CustomerRedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {

        if($request->routeIs("front.customer.signout.submit"))
            return $next($request);

        if(Auth::guard("user")->check())
            return redirect()->route("front.customer.dashboard")->with("error","You are already logged in!");

        return $next($request);
    }
}
