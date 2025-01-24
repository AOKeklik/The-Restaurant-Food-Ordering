<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminHomeController;
use Illuminate\Support\Facades\Route;

Route::prefix("admin")->middleware("admin.guest")->group(function(){
    /* login */
    Route::get("login", [AdminAuthController::class, "login"])->name("admin.login");
    Route::post("login/submit", [AdminAuthController::class, "login_submit"])->name("admin.login.submit");
    Route::get("logout/submit", [AdminAuthController::class,"logout_submit"])->name("admin.logout.submit");

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
});


