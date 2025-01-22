<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    public function login():View{
        return view("auth.login");
    }
    public function login_submit(){
        echo "ll";
    }
}
