<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminHomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::prefix("admin")->group(function(){
    /* login */
    Route::get("login", [AdminAuthController::class, "login"])->name("login");
    Route::post("login/submit", [AdminAuthController::class, "login_submit"])->name("login.submit");
});

Route::prefix("admin")->middleware("auth")->group(function () {
    /* dashboard */
    Route::get("", [AdminHomeController::class, "index"])->name("admin.index");
});



