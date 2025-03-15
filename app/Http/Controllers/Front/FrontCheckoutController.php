<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\DeliveryArea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class FrontCheckoutController extends Controller
{
    public function checkout_view(){
        $addresses=[];
        
        if(Auth::guard("user")->check())
            $addresses=Address::
                where("user_id",Auth::guard("user")->user()->id)->
                orderBy("id","DESC")->get();

        if(!Auth::guard("user")->check() && isset(Session::get("cart")["addresses"]))
            $addresses=Session::get("cart")["addresses"];

        $deliveryAreas=DeliveryArea::where("status",1)->orderBy("id","DESC")->get();
        return view("front.checkout.index",compact("addresses","deliveryAreas"));
    }
    public function checkout_view_ajax_page(){
        $addresses=[];
        
        if(Auth::guard("user")->check())
            $addresses=Address::
                where("user_id",Auth::guard("user")->user()->id)->
                orderBy("id","DESC")->get();

        if(!Auth::guard("user")->check() && isset(Session::get("cart")["addresses"]))
            $addresses=Session::get("cart")["addresses"];
                
        $deliveryAreas=DeliveryArea::where("status",1)->orderBy("id","DESC")->get();
        return view("front.checkout.ajax_page",compact("addresses","deliveryAreas"));
    }



    public function checkout_store_ajax_addresses (Request $request) {
        try{
            $rules=[
                "first_name"=>"required|string",
                "last_name"=>"nullable|string",
                "phone"=>"required",
                "email"=>"required|email",
                "delivery_area_id"=>"required|exists:delivery_areas,id",
                "address"=>"required",
                "type"=>"required|string|in:home,office",
            ];

            if (Auth::guard('user')->check())
                $rules["user_id"] = "required|numeric|exists:users,id";
               
            $validator = \Validator::make($request->all(), $rules);
    
            if(!$validator->passes())
                return response()->json(["error_form"=>["message"=>$validator->errors()->toArray()]]);


            if(!Auth::guard("user")->check()){
                $deliveryArea=DeliveryArea::find($request->delivery_area_id);

                $cart=Session::get("cart", []);
                $cart["addresses"][$request->type]["user_id"]= "guest";
                $cart["addresses"][$request->type]["id"]= uniqid();
                $cart["addresses"][$request->type]["delivery_area_id"]=$deliveryArea->id;
                $cart["addresses"][$request->type]["delivery_area_name"]=$deliveryArea->name;
                $cart["addresses"][$request->type]["delivery_area_fee"]=$deliveryArea->fee;
                $cart["addresses"][$request->type]["type"]=$request->type;
                $cart["addresses"][$request->type]["first_name"]=$request->first_name;
                if($request->last_name) $cart["addresses"][$request->type]["last_name"]=$request->last_name;
                $cart["addresses"][$request->type]["email"]=$request->email;
                $cart["addresses"][$request->type]["phone"]=$request->phone;
                $cart["addresses"][$request->type]["address"]=$request->address;

                Session::put('cart', $cart);
            }
                

            if(Auth::guard("user")->check()) {
                $addresses=Address::where('user_id', $request->user_id)->get();

                if($addresses->count() >= 4)
                    return response()->json(["error"=>["message"=>"You can only have 4 addresses."]]);

                $address=new Address();
                $address->user_id=$request->user_id;
                $address->delivery_area_id=$request->delivery_area_id;
                $address->type=$request->type;
                $address->first_name=$request->first_name;
                if($request->last_name) $address->last_name=$request->last_name;
                $address->email=$request->email;
                $address->phone=$request->phone;
                $address->address=$request->address;

                if(!$address->save())
                    return response()->json(["error"=>["message"=>"Failed to create address."]]);
            }
            
            return response()->json(["success"=>["message"=>"Address created successfully."]]);
        }catch(\Exception $err){
            return response()->json(["error"=>["message"=>$err->getMessage()]]);
        }
    }
    public function checkout_store_ajax_address (Request $request) {
        try {
            $validator = \Validator::make($request->all(), [
                "address_id" => "required",
            ]);
    
            if (!$validator->passes()) {
                return response()->json(["error" => ["message" => $validator->errors()->first()]]);
            }
    
            if(!Auth::guard("user")->check()){
                $cart = Session::get("cart", []);    
                $filtered=array_filter($cart["addresses"],fn($item)=> isset($item["id"]) && $item["id"] === $request->address_id);
                $cart["address"] = !empty($filtered) ? reset($filtered) : null;
            }


            if(Auth::guard("user")->check()){
                $address = DeliveryArea::where("id", $request->address_id);

                if (!$address) {
                    return response()->json(["error" => ["message" => "Delivery area not found"]]);
                }
            }

            Session::put("cart", $cart);

            return response()->json(["success" => ["message" => "Cart updated successfully"]]);
        } catch (\Exception $e) {
            return response()->json(["error" => ["message" => $e->getMessage()]]);
        }
    }
}
