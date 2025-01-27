<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CustomerAuthenticate
{
    public function handle(Request $request, Closure $next): Response
    {

        if(!Auth::guard("user")->check() || Auth::guard("user")->user()->role !== "customer")
            return redirect()->route("front.customer.signin")->with("error","You must be logged in as an customer to access this page!");

        return $next($request);
    }
}
