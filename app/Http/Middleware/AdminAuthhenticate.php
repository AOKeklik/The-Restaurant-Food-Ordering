<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAuthhenticate
{
    public function handle(Request $request, Closure $next): Response
    {
        if(!Auth::guard('user')->check())
            return redirect()->route("admin.signin")->with("error","You must be logged in as an admin to access this page!");

        if(Auth::guard("user")->user()->role !== "admin") {
            Auth::guard("user")->logout();
            return redirect()->route("admin.signin")->with("error","Unauthorized access");
        }
        
        return $next($request);
    }
}
