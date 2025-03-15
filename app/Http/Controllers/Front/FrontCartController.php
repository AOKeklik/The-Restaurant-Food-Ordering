<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Option;
use App\Models\Product;
use App\Models\ProductSizes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;


class FrontCartController extends Controller
{
    public function cart() 
    {
        return view("front.cart.index");
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

        return view("front.cart.ajax_popup",compact("product","options"));
    }
    public function cart_ajax_count () 
    {
        return view("front.cart.ajax_count");
    }
    public function cart_ajax_items () 
    {
        return view("front.cart.ajax_items");
    }
    public function cart_ajax_page () 
    { 
        return view("front.cart.ajax_page");
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
                "current_url" => "required|url",
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
            else {
                Session::forget("cart");

                if(isset($request->current_url) && $request->current_url === route("front.order.checkout.view"))
                    return response()->json(["redirect" => ["link" => route("front.order.cart")]]);
            }
                
    
            return response()->json(["success" => ["message" => "Product removed from cart successfully!"]]);
        } catch (\Exception $e) {
            return response()->json(["error" => ["message" => $e->getMessage()]]);
        }
    }
}
