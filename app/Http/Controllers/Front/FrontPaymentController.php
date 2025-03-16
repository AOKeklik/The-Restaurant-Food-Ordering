<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class FrontPaymentController extends Controller
{
    public function payment_view()
    {

        if(Session::has("cart") && !isset(Session::get("cart")["address"]))
            return redirect()->back()->with("error","asdf");
        
        return view("front.payment.index");
    }
}
