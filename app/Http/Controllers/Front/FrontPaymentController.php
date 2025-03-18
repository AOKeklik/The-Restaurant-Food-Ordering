<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class FrontPaymentController extends Controller
{
    public function payment_view()
    {

        if(Session::has("cart") && empty(Session::get("cart")["address"]))
            return redirect()->back()->with("error","Please select an address to proceed to the payment page.");
        
        return view("front.payment.index");
    }

    public function payment_store_ajax(Request $request, OrderService $order){
        try {
            $validator=\Validator::make($request->all(), [
                "payment_method" => "required|string|in:paypal,stripe",
            ]);
    
            if (!$validator->passes())
                return response()->json(["error" => ["message" => $validator->errors()->first()]]);

            $order::create();
    
            // $cart = Session::get("cart", []);
            // $address = Address::find($request->address_id);

            // if (!$address)
            //     return response()->json(["error" => ["message" => "Please choose a delivery address before proceeding to payment."]]);
            
            // $cart["address"] = [
            //     "id"=>$address->id,
            //     "fee"=>$address->deliveryArea->fee,
            // ];

            // Session::put("cart", $cart);

            return response()->json(["success" => ["message" => "Cart updated successfully","redirect"=>route("front.order.payment.view")]]);
        } catch (\Exception $e) {
            return response()->json(["error" => ["message" => $e->getMessage()]]);
        }
    }
}
