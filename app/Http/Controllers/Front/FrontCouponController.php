<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Coupon;
use Illuminate\Support\Facades\Session;

class FrontCouponController extends Controller
{
    public function coupon_ajax_submit (Request $request) 
    {
        try {
            $validator = \Validator::make($request->all(), [
                "code" => "required|string|exists:coupons,code",
            ]);
    
            if (!$validator->passes()) {
                return response()->json(["error" => ["message" => $validator->errors()->first()]]);
            }
    
            $cart = Session::get("cart", []);
            $coupon = Coupon::where("code",$request->code)->first();

            if(!$coupon || $coupon->status == 0)
                return response()->json(["error" => ["message" => "Invalid or inactive coupon."]]);

            if($coupon->quantity < 1)
                return response()->json(["error" => ["message" => "Coupon has been fully redeemed."]]);

            if(cartSubTotal() < $coupon->min_purchase_amount)
                return response()->json(["error" => ["message" => "Minimum purchase amount not met."]]);

            if(date('Y-m-d') > $coupon->expire_date)
                return response()->json(["error" => ["message" => "Coupon has expired."]]);

            $total=cartSubTotal();
            $discount=0;
            if($coupon->discount == "percent"){
                $discount= ($coupon->discount / 100) * $total;
                $total -= $discount;
            }else{
                $discount=$coupon->discount;
                $total -= $discount;
            }

            $coupon->quantity -= 1;
            
            if(!$coupon->save())
                return response()->json(["error" => ["message" => "Failed to update coupon usage. Please try again."]]);

            $cart["coupon"]=[
                "code"=>$coupon->code,
                "discount"=>$discount,
            ];

            Session::put("cart", $cart);
    
            return response()->json(["success" => ["message"=>"Coupon successfully aplied."]]);
        } catch (\Exception $e) {
            return response()->json(["error" => ["message" => $e->getMessage()]]);
        }
    }
    public function coupon_ajax_remove () 
    {
        try {    
            $cart = Session::get("cart", []);            
            unset($cart["coupon"]);

            Session::put("cart", $cart);
    
            return response()->json(["success" => ["message" => "Coupon removed from cart successfully!","discount"=>0,"total"=>cartTotal()]]);
        } catch (\Exception $e) {
            return response()->json(["error" => ["message" => $e->getMessage()]]);
        }
    }
}
