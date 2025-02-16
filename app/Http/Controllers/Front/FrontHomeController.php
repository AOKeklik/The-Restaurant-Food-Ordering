<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Models\WhyChoose;

class FrontHomeController extends Controller
{
    public function index(){
        $slides=Slider::where("status",true)->orderBy("id","desc")->limit(3)->get();
        $whyChooses=WhyChoose::where("status",true)->orderBy("id","desc")->limit(3)->get();

        return view("front.home",compact("slides","whyChooses"));
    }
}
