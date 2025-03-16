<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerCart
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->ajax() || $request->wantsJson()) {
            if(!$request->session()->has("cart")) {
                // return response()->json(["redirect" => ["link" => route("front.order.cart")]]);
                return response()->json(["error"=>['message' => 'Cart is empty, please add items to your cart.']]);
            }
        }

        if(!$request->session()->has("cart"))
            return redirect()->route("front.order.cart")->with("error","Cart is empty, please add items to your cart.");

        return $next($request);
    }
}
