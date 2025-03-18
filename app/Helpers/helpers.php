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
                $count+=$item["quantity"];
            }
        }

        return $count;
    }
}

if(!function_exists("cartItemSubTotal")){
    function cartItemSubTotal ($product_id) {
        $total = 0;
        $cartItem=Session::get("cart")["cart"][$product_id];
       
        $price=$cartItem["price"];
        $size_price=isset($cartItem["size"]) ? $cartItem["size"]["price"] : 0;
        $options_price=0;

        if(isset($cartItem["options"]))
            foreach($cartItem["options"] as $option)
                $options_price += $option["price"];

        $total += ($price + $size_price + $options_price) * $cartItem["quantity"];   
        
        return $total;
    }
}

if(!function_exists("cartSubTotal")){
    function cartSubTotal () {
        $total = 0;
        if(Session::has("cart"))
            foreach(Session::get("cart")["cart"] as $key=>$val) {
                $price=$val["price"];
                $size_price=isset($val["size"]) ? $val["size"]["price"] : 0;
                $options_price=0;

                if(isset($val["options"]))
                    foreach($val["options"] as $option)
                        $options_price += $option["price"];

                $total += ($price + $size_price + $options_price) * $val["quantity"];   
            }

        return $total;
    }
}

if(!function_exists("cartTotalExcludingShipping")){
    function cartTotalExcludingShipping () {
        $total = cartSubTotal();
        $discount=Session::get("cart")["coupon"]["discount"] ?? 0;

        if(isset(Session::get("cart")["coupon"]))
            $total = $total - $discount;

        return $total;
    }
}

if(!function_exists("cartTotal")){
    function cartTotal () {        
        $total = cartSubTotal() + deliveryFee();
        $discount=Session::get("cart")["coupon"]["discount"] ?? 0;

        if(isset(Session::get("cart")["coupon"]))
            $total = $total -  $discount;

        return $total;
    }
}


if(!function_exists("deliveryFee")){
    function deliveryFee(){
        $settings = Setting::first();
        $deliveryFee = $settings->site_delivery_charge ?? 0;
        
        if(isset(Session::get("cart")["address"]))
            $deliveryFee = $deliveryFee + Session::get("cart")["address"]["fee"];
        
        return $deliveryFee;

    }
}

if(!function_exists("deliveryTime")){
    function deliveryTime ($val) {
        $hours = floor($val / 60);
        $minutes= $val % 60;
        return sprintf("%02d:%02d", $hours, $minutes); // Format as HH:MM
    }
}

if(!function_exists("paymentInvoiceId")){
    function paymentInvoiceId () {
        $now=now();
        $date=$now->format("Ymd");
        $time=$now->format("His");

        return uniqid().$date.$time;
    }
}