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
            foreach(Session::get("cart") as $item){
                $count+=$item["product_info"]["quantity"];
            }
        }

        return $count;
    }
}

if(!function_exists("cartTotal")){
    function cartTotal () {
        $total = 0;
        foreach(Session::get("cart") as $key=>$val) {
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


if(!function_exists("cartItemTotal")){
    function cartItemTotal ($product_id) {
        $total = 0;
        $cartItem=Session::get("cart")[$product_id];
       
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