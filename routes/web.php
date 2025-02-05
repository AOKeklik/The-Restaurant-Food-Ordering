<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Front\CustomerAuthController;
use App\Http\Controllers\Front\HomeController;
use Illuminate\Support\Facades\Route;

/* ********** ADMIN *********** */

Route::prefix("admin")->middleware("admin.guest")->group(function(){
    /* signin */
    Route::get("signin", [AdminAuthController::class, "signin"])->name("admin.signin");
    Route::post("signin/submit", [AdminAuthController::class, "signin_submit"])->name("admin.signin.submit");
    Route::get("signout/submit", [AdminAuthController::class,"signout_submit"])->name("admin.signout.submit");

    /* forget */
    Route::get("forget",[AdminAuthController::class, "forget"])->name("admin.forget");
    Route::post("forget/submit",[AdminAuthController::class,"forget_submit"])->name("admin.forget.submit");
    
    /* reset */
    Route::get("reset",[AdminAuthController::class,"reset"])->name("admin.reset");
    Route::post("reset/submit",[AdminAuthController::class,"reset_submit"])->name("admin.reset.submit");
});

Route::prefix("admin")->middleware("admin.logedin")->group(function () {
    /* dashboard */
    Route::get("", [AdminHomeController::class, "index"])->name("admin.index");

    /* profile */
    Route::get("/profile/edit",[AdminProfileController::class,"profile_edit"])->name("admin.profile.edit");
    Route::post("/profile/update",[AdminProfileController::class,"profile_update"])->name("admin.profile.update");
});


/* ********** CUSTOMER *********** */

Route::prefix("customer")->middleware("customer.guest")->group(function(){
    /* signup */
    Route::get("signup",[CustomerAuthController::class,"signup"])->name("front.customer.signup");
    Route::post("signup/submit",[CustomerAuthController::class,"signup_submit"])->name("front.customer.signup.submit");
    Route::get("signup/verify/submit",[CustomerAuthController::class,"signup_verify_submit"])->name("front.customer.signup.verify.submit");

    /* signin */
    Route::get("signin",[CustomerAuthController::class,"signin"])->name("front.customer.signin");
    Route::post("signin/submit",[CustomerAuthController::class,"signin_submit"])->name("front.customer.signin.submit");

    /* signout */
    Route::post("signout/submit",[CustomerAuthController::class,"signout_submit"])->name("front.customer.signout.submit");

    /* forget */
    Route::get("forget",[CustomerAuthController::class,"forget"])->name("front.customer.forget");
    Route::post("forget/submit",[CustomerAuthController::class,"forget_submit"])->name("front.customer.forget.submit");

    /* reset password */
    Route::get("reset",[CustomerAuthController::class,"reset"])->name("front.customer.reset");
    Route::post("reset/submit",[CustomerAuthController::class,"reset_submit"])->name("front.customer.reset.submit");
});

Route::prefix("customer")->middleware("customer.logedin")->group(function(){
    Route::get("dashboard",[HomeController::class,"dashboard"])->name("front.customer.dashboard");
});


/* ********** FRONT *********** */


Route::prefix("/")->group(function(){
    Route::get("",[HomeController::class,"index"])->name("front.index");
});

