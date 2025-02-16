<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\AdminProductCategoryController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Admin\AdminSliderController;
use App\Http\Controllers\Admin\AdminWhyChooseController;
use App\Http\Controllers\Front\CustomerAuthController;
use App\Http\Controllers\Front\CustomerProfileController;
use App\Http\Controllers\Front\HomeController;
use Illuminate\Support\Facades\Route;

/* ********** ADMIN *********** */

Route::prefix("admin")->middleware("admin.redirectIfAuthenticated")->group(function(){
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

Route::prefix("admin")->middleware("admin.authenticate")->group(function () {
    /* dashboard */
    Route::get("", [AdminHomeController::class, "index"])->name("admin.index");

    /* profile */
    Route::get("profile/edit",[AdminProfileController::class,"profile_edit"])->name("admin.profile.edit");
    Route::post("profile/update",[AdminProfileController::class,"profile_update"])->name("admin.profile.update");

    /* settings */
    Route::post("setting/slider/update",[AdminSettingController::class,"slider_update"])->name("admin.setting.slider.update");
    Route::post("setting/why_choose/update",[AdminSettingController::class,"why_choose_update"])->name("admin.setting.why_choose.update");

    /* slider */
    Route::get("sliders",[AdminSliderController::class,"slides"])->name("admin.slides");
    Route::get("slider/add",[AdminSliderController::class,"slides_add"])->name("admin.slide.add");
    Route::get("slider/edit/{slide_id}",[AdminSliderController::class,"slides_edit"])->name("admin.slide.edit");
    Route::post("slider/store",[AdminSliderController::class,"slides_store"])->name("admin.slide.store");
    Route::post("slider/update",[AdminSliderController::class,"slides_update"])->name("admin.slide.update");
    Route::post("slider/status/update",[AdminSliderController::class,"slides_status_update"])->name("admin.slide.status.update");
    Route::post("slider/delete",[AdminSliderController::class,"slides_delete"])->name("admin.slide.delete");

    /* why choose */
    Route::get("why-chooses",[AdminWhyChooseController::class,"why_chooses"])->name("admin.why_chooses");
    Route::get("why-choose/add",[AdminWhyChooseController::class,"why_choose_add"])->name("admin.why_choose.add");
    Route::get("why-choose/edit/{why_choose_id}",[AdminWhyChooseController::class,"why_choose_edit"])->name("admin.why_choose.edit");
    Route::post("why-choose/store",[AdminWhyChooseController::class,"why_choose_store"])->name("admin.why_choose.store");
    Route::post("why-choose/update",[AdminWhyChooseController::class,"why_choose_update"])->name("admin.why_choose.update");
    Route::post("why-choose/status/update",[AdminWhyChooseController::class,"why_choose_status_update"])->name("admin.why_choose.status.update");
    Route::post("why-choose/delete",[AdminWhyChooseController::class,"why_choose_delete"])->name("admin.why_choose.delete");

    /* product categories */
    Route::get("product/categories",[AdminProductCategoryController::class,"product_categories"])->name("admin.product.categories");
    Route::get("product/category/add",[AdminProductCategoryController::class,"product_category_add"])->name("admin.product.category.add");
    Route::get("product/category/edit/{category_id}",[AdminProductCategoryController::class,"product_category_edit"])->name("admin.product.category.edit");
    Route::post("product/category/store",[AdminProductCategoryController::class,"product_category_store"])->name("admin.product.category.store");
    Route::post("product/category/update",[AdminProductCategoryController::class,"product_category_update"])->name("admin.product.category.update");
    Route::post("product/category/status/update",[AdminProductCategoryController::class,"product_category_status_update"])->name("admin.product.category.status.update");
    Route::post("product/category/home/update",[AdminProductCategoryController::class,"product_category_home_update"])->name("admin.product.category.home.update");
    Route::post("product/category/delete",[AdminProductCategoryController::class,"product_category_delete"])->name("admin.product.category.delete");
});


/* ********** CUSTOMER *********** */

Route::prefix("customer")->middleware("customer.redirectIfAuthenticated")->group(function(){
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

Route::prefix("customer")->middleware("customer.authenticate")->group(function(){
    Route::get("",[CustomerProfileController::class,"dashboard"])->name("front.customer.dashboard");

    /* profile */
    Route::post("avatar/update",[CustomerProfileController::class,"avatar_update"])->name("front.customer.avatar.update");
    Route::post("profile/update",[CustomerProfileController::class,"profile_update"])->name("front.customer.profile.update");
    Route::post("password/update",[CustomerProfileController::class,"password_update"])->name("front.customer.password.update");
});


/* ********** FRONT *********** */


Route::prefix("/")->group(function(){
    Route::get("",[HomeController::class,"index"])->name("front.index");
});

