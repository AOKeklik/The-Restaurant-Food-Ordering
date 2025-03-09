<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Session;

if(!function_exists("currency")){
    function currency($price){
        $settings = Setting::first();
        
        if($settings->site_currency_position == "left")
            return $price." ".$settings->site_currency_icon;
        else
            return $settings->site_currency_icon." ".$price;

    }
}

if(!function_exists("cartItemCount")) {
    function cartItemCount () {
        $count=0;

        if(Session::has("cart")) {
            foreach(Session::get("cart")["cart"] as $item){
                $count+=$item["product_info"]["quantity"];
            }
        }

        return $count;
    }
}

if(!function_exists("cartItemSubTotal")){
    function cartItemSubTotal ($product_id) {
        $total = 0;
        $cartItem=Session::get("cart")["cart"][$product_id];
       
        $price=$cartItem["product_info"]["price"];
        $size_price=isset($cartItem["product_size"]) ? $cartItem["product_size"]["price"] : 0;
        $options_price=0;

        if(isset($cartItem["product_options"]))
            foreach($cartItem["product_options"] as $option)
                $options_price += $option["price"];

        $total += ($price + $size_price + $options_price) * $cartItem["product_info"]["quantity"];   
        
        return $total;
    }
}

if(!function_exists("cartSubTotal")){
    function cartSubTotal () {
        $total = 0;
        if(Session::has("cart"))
            foreach(Session::get("cart")["cart"] as $key=>$val) {
                $price=$val["product_info"]["price"];
                $size_price=isset($val["product_size"]) ? $val["product_size"]["price"] : 0;
                $options_price=0;

                if(isset($val["product_options"]))
                    foreach($val["product_options"] as $option)
                        $options_price += $option["price"];

                $total += ($price + $size_price + $options_price) * $val["product_info"]["quantity"];   
            }

        return $total;
    }
}

if(!function_exists("cartTotal")){
    function cartTotal () {
        $settings = Setting::first();
        $total = cartSubTotal() + $settings->site_delivery_charge;

        if(isset(Session::get("cart")["coupon"]))
            $total = $total - Session::get("cart")["coupon"]["discount"];

        return $total;
    }
}

if(!function_exists("formatDeliveryTime")){
    function formatDeliveryTime ($val) {
        $hours = floor($val / 60);
        $minutes= $val % 60;
        return sprintf("%02d:%02d", $hours, $minutes); // Format as HH:MM
    }
}