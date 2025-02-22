<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Option;
use App\Models\Product;
use Illuminate\Contracts\View\View;

class FrontProductController extends Controller
{
    public function product($product_id,$product_slug):View{
        $product=Product::
            where("id",$product_id)->
            where("slug",$product_slug)->
            first();

        if(!$product)
            return view("front.404");

        $options=Option::whereIn("id",explode(",",$product->options))->get();

        $related_products=Product::
            where("id","!=",$product->id)->
            where("category_id",$product->category_id)->
            orderBy("id","DESC")->
            take(8)->
            get();

        return view("front.product",compact("product","options","related_products"));
    }
}
