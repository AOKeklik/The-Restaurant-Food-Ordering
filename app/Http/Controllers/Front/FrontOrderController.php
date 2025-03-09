<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Option;
use App\Models\Product;
use App\Models\ProductSizes;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class FrontOrderController extends Controller
{
    public function cart() 
    {
        return view("front.cart");
    }
    public function cart_ajax_popup (Request $request) 
    {
        $validator = \Validator::make($request->all(), [
            "product_id" => "required|numeric|exists:products,id",
        ]);
    
        if (!$validator->passes()) {
            return response()->json(["error" => ["message" => $validator->errors()->first()]]);
        }

        $product=Product::find($request->product_id);
        $options =Option::whereIn("id",explode(",",$product->options))->get();

        return view("front.component.cart_ajax_popup",compact("product","options"));
    }
    public function cart_ajax_count () 
    {
        return view("front.component.cart_ajax_count");
    }
    public function cart_ajax_items () 
    {
        return view("front.component.cart_ajax_items");
    }
    public function cart_ajax_page () 
    {
        return view("front.component.cart_ajax_page");
    }
    public function cart_ajax_submit(Request $request)
    {
        try {
            $validator = \Validator::make($request->all(), [
                "product_id" => "required|numeric|exists:products,id",
                "product_size" => "nullable|numeric|exists:product_sizes,id",
                "options" => "nullable|array",
                "options.*" => "exists:options,id",
                "quantity" => "required|numeric",
            ]);
        
            if (!$validator->passes()) {
                return response()->json(["error" => ["message" => $validator->errors()->first()]]);
            }
        
            $cart = Session::get("cart", []);
            $product = Product::find($request->product_id);

            if($product->max_quantity > -1 && $request->quantity > $product->max_quantity)
                return response()->json(["error" => ["message" => "Requested quantity exceeds the available stock limit of " . $product->max_quantity . "."]]);

            $cart["cart"][$product->id] = [
                "product_info"=>[
                    "id" => $product->id,
                    "slug" => $product->slug,
                    "name" => $product->name,
                    "image" => $product->image,
                    "price" => $product->offer_price > 0 ? $product->offer_price : $product->price,
                    "quantity" => $request->quantity,
                ]
            ];
        
            if (filter_var($request->product_size, FILTER_VALIDATE_INT)) {
                $product_size = ProductSizes::find($request->product_size);
    
                $cart["cart"][$product->id]["product_size"] = [
                    "id"=>$product_size->id,
                    "name"=>$product_size->name,
                    "price"=>$product_size->price,
                ]; 
            }
        
            if (!empty($request->options)) {
                $options = Option::whereIn("id",$request->options)->get();
    
                foreach($options as $option)
                    $cart["cart"][$product->id]["product_options"][] = [
                        "id"=>$option->id,
                        "name"=>$option->name,
                        "price"=>$option->price,
                    ];
            }     
        
            Session::put('cart', $cart);
        
            return response()->json(["success" => ["message" => "Product added to cart successfully!"]]);
        } catch(\Exception $err){
            return response()->json(["error" => ["message" => $err->getMessage()]]);
        }
    }
    public function cart_ajax_quantity (Request $request) 
    {
        try {
            $validator = \Validator::make($request->all(), [
                "product_id" => "required|numeric|exists:products,id",
                "quantity" => "required|numeric",
            ]);
    
            if (!$validator->passes()) {
                return response()->json(["error" => ["message" => $validator->errors()->first()]]);
            }
    
            $cart = Session::get("cart", []);
            $product = Product::find($request->product_id);

            if($product->max_quantity > -1 && $request->quantity > $product->max_quantity)
                return response()->json(["error" => ["message" => "Requested quantity exceeds the available stock limit of " . $product->max_quantity . "."]]);

            if (!isset($cart) || !array_key_exists($request->product_id, $cart["cart"]))
                return response()->json(["error" => ["message" => "Product not found in cart."]]);
    
            $cart["cart"][ $request->product_id]["product_info"]["quantity"] = $request->quantity;
            Session::put("cart", $cart);

            return response()->json(["success" => ["message" => "Cart updated successfully"]]);
        } catch (\Exception $e) {
            return response()->json(["error" => ["message" => $e->getMessage()]]);
        }
    }
    public function cart_ajax_coupon_submit (Request $request) 
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
            $settings = Setting::first();

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

            $delivery=number_format($settings->site_delivery_charge,2);
            $total=number_format($total + $settings->site_delivery_charge,2);

            $cart["coupon"]=[
                "code"=>$coupon->code,
                "discount"=>$discount,
            ];

            Session::put("cart", $cart);
    
            return response()->json(["success" => ["message"=>"Coupon successfully aplied.","code"=>$coupon->code,"discount"=>$discount,"total"=>$total]]);
        } catch (\Exception $e) {
            return response()->json(["error" => ["message" => $e->getMessage()]]);
        }
    }
    public function cart_ajax_coupon_remove () 
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
    public function cart_ajax_items_remove () 
    {
        try {    
            $cart = Session::get("cart", []);

            if(empty($cart))
                return response()->json(["error" => ["message" => "Your cart is already empty."]]);
    
            Session::forget("cart");
    
            return response()->json(["success" => ["message" => "Product removed from cart successfully!"]]);
        } catch (\Exception $e) {
            return response()->json(["error" => ["message" => $e->getMessage()]]);
        }
    }
    public function cart_ajax_item_remove (Request $request) 
    {
        try {
            $validator = \Validator::make($request->all(), [
                "product_id" => "required|numeric|exists:products,id",
            ]);
    
            if (!$validator->passes()) {
                return response()->json(["error" => ["message" => $validator->errors()->first()]]);
            }
    
            $cart = Session::get("cart", []);
    
            if (isset($cart) && array_key_exists($request->product_id, $cart["cart"])) {
                unset($cart["cart"][ $request->product_id]);
            }
    
            if(count($cart["cart"]) > 0)
                Session::put("cart", $cart);
            else
                Session::forget("cart");
    
            return response()->json(["success" => ["message" => "Product removed from cart successfully!"]]);
        } catch (\Exception $e) {
            return response()->json(["error" => ["message" => $e->getMessage()]]);
        }
    }
}
