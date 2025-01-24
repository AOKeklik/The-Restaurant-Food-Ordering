<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminRedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {

        if($request->routeIs("admin.logout.submit"))
            return $next($request);

        if(Auth::guard('user')->check())
            return redirect()->route("admin.index")->with("error","You are already logged in!");

        return $next($request);
    }
}
