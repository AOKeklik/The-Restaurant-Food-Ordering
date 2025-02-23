<?php

use App\Models\Setting;


if(!function_exists("currency")){
    function currency($price){
        $settings = Setting::first();
        
        if($settings->site_currency_position == "left")
            return $price." ".$settings->site_currency_icon;
        else
            return $settings->site_currency_icon." ".$price;

    }
}