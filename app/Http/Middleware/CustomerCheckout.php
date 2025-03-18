<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CustomerCheckout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->ajax() || $request->wantsJson()) {
            if(!Auth::guard("user")->check())
                return response()->json(["error"=>[
                    "message"=>"You must be logged in as an customer!",
                    "redirect" => route("front.customer.signin")
                ]]);

            if(!$request->session()->has("cart"))
                return response()->json(["error"=>["message"=>"Cart is empty, please add items to your cart.","redirect" => route("front.order.cart")]]);
        }

        if(!$request->session()->has("cart"))
            return redirect()->route("front.order.cart")->with("error","Cart is empty, please add items to your cart.");

        if(!Auth::guard("user")->check())
            return redirect()->route("front.order.cart")->with("error","You must be logged in as an customer!");

        return $next($request);
    }
}
