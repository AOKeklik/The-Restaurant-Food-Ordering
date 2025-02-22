<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminOptionController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminProductImageController;
use App\Http\Controllers\Admin\AdminProductSizeController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Admin\AdminSliderController;
use App\Http\Controllers\Admin\AdminWhyChooseController;
use App\Http\Controllers\Front\CustomerAuthController;
use App\Http\Controllers\Front\FrontCustomerProfileController;
use App\Http\Controllers\Front\FrontHomeController;
use App\Http\Controllers\Front\FrontProductController;
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

    /* categories */
    Route::get("categories",[AdminCategoryController::class,"categories"])->name("admin.categories");
    Route::get("category/add",[AdminCategoryController::class,"category_add"])->name("admin.category.add");
    Route::get("category/edit/{category_id}",[AdminCategoryController::class,"category_edit"])->name("admin.category.edit");
    Route::post("category/store",[AdminCategoryController::class,"category_store"])->name("admin.category.store");
    Route::post("category/update",[AdminCategoryController::class,"category_update"])->name("admin.category.update");
    Route::post("category/status/update",[AdminCategoryController::class,"category_status_update"])->name("admin.category.status.update");
    Route::post("category/home/update",[AdminCategoryController::class,"category_home_update"])->name("admin.category.home.update");
    Route::post("category/delete",[AdminCategoryController::class,"category_delete"])->name("admin.category.delete");

    /* options */
    Route::get("options",[AdminOptionController::class,"options"])->name("admin.options");
    Route::get("option/add",[AdminOptionController::class,"option_add"])->name("admin.option.add");
    Route::get("option/edit/{option_id}",[AdminOptionController::class,"option_edit"])->name("admin.option.edit");
    Route::post("option/store",[AdminOptionController::class,"option_store"])->name("admin.option.store");
    Route::post("option/update",[AdminOptionController::class,"option_update"])->name("admin.option.update");
    Route::post("option/status/update",[AdminOptionController::class,"option_status_update"])->name("admin.option.status.update");
    Route::post("option/delete",[AdminOptionController::class,"option_delete"])->name("admin.option.delete");

    /* products */
    Route::get("products",[AdminProductController::class,"products"])->name("admin.products");
    Route::get("product/add",[AdminProductController::class,"product_add"])->name("admin.product.add");
    Route::post("product/store",[AdminProductController::class,"product_store"])->name("admin.product.store");
    Route::get("product/edit/{product_id}",[AdminProductController::class,"product_edit"])->name("admin.product.edit");
    Route::post("product/update",[AdminProductController::class,"product_update"])->name("admin.product.update");
    Route::post("product/status/update",[AdminProductController::class,"product_status_update"])->name("admin.product.status.update");
    Route::post("product/home/update",[AdminProductController::class,"product_home_update"])->name("admin.product.home.update");
    Route::post("product/delete",[AdminProductController::class,"product_delete"])->name("admin.product.delete");

    /* product images */
    Route::get("product/images/{product_id}",[AdminProductImageController::class,"images"])->name("admin.product.images");
    Route::post("product/image/store",[AdminProductImageController::class,"image_store"])->name("admin.product.image.store");
    Route::post("product/image/update",[AdminProductImageController::class,"image_update"])->name("admin.product.image.update");
    Route::post("product/image/status/update",[AdminProductImageController::class,"image_status_update"])->name("admin.product.image.status.update");
    Route::post("product/image/delete",[AdminProductImageController::class,"image_delete"])->name("admin.product.image.delete");

    /* product sizes */
    Route::get("product/sizes/{product_id}",[AdminProductSizeController::class,"sizes"])->name("admin.product.sizes");
    Route::post("product/size/store",[AdminProductSizeController::class,"size_store"])->name("admin.product.size.store");
    Route::get("product/size/edit/{size_id}",[AdminProductSizeController::class,"size_edit"])->name("admin.product.size.edit");
    Route::post("product/size/update",[AdminProductSizeController::class,"size_update"])->name("admin.product.size.update");
    Route::post("product/size/status/update",[AdminProductSizeController::class,"size_status_update"])->name("admin.product.size.status.update");
    Route::post("product/size/delete",[AdminProductSizeController::class,"size_delete"])->name("admin.product.size.delete");
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
    Route::get("",[FrontCustomerProfileController::class,"dashboard"])->name("front.customer.dashboard");

    /* profile */
    Route::post("avatar/update",[FrontCustomerProfileController::class,"avatar_update"])->name("front.customer.avatar.update");
    Route::post("profile/update",[FrontCustomerProfileController::class,"profile_update"])->name("front.customer.profile.update");
    Route::post("password/update",[FrontCustomerProfileController::class,"password_update"])->name("front.customer.password.update");
});


/* ********** FRONT *********** */


Route::prefix("/")->group(function(){
    Route::get("",[FrontHomeController::class,"index"])->name("front.index");

    /* product */
    Route::get("products",[FrontProductController::class,"products"])->name("front.products");
    Route::get("product/{product_id}/{product_slug}",[FrontProductController::class,"product"])->name("front.product");
});

