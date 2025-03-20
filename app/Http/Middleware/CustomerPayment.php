<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CustomerPayment
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if ($request->ajax() || $request->wantsJson())
            if(!isset($request->session()->get("cart")["address"]))
                return response()->json(["error"=>["message"=>"Please select a delivery address to proceed with your order.","redirect"=>route("front.order.checkout.view")]]);

        if(!isset($request->session()->get("cart")["address"]))
            return redirect()->route("front.order.cart")->with("error","Please select a delivery address to proceed with your order.");

            
        return $next($request);
    }
}
