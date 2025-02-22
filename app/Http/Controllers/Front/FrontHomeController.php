<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use App\Models\WhyChoose;

class FrontHomeController extends Controller
{
    public function index(){
        $slides=Slider::where("status",true)->orderBy("id","desc")->limit(3)->get();
        $whyChooses=WhyChoose::where("status",true)->orderBy("id","desc")->limit(3)->get();
        $categories=Category::
            where("status",1)->
            where("show_on_homepage",1)->
            orderBy("id","desc")->
            limit(4)->
            get();
        $products=Product::
            where("status",1)->
            where("show_on_homepage",1)->
            orderBy("id","desc")->
            limit(8)->
            get();

        return view("front.home",
            compact(
                "slides",
                "whyChooses",
                "categories",
                "products"
            )
        );
    }
}
