<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AdminHomeController extends Controller
{
    public function index() :View{
        return view("admin.home");
    }
}