<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminCouponController;
use App\Http\Controllers\Admin\AdminDeliveryAreasController;
use App\Http\Controllers\Admin\AdminOptionController;
use App\Http\Controllers\Admin\AdminPaymentController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminProductImageController;
use App\Http\Controllers\Admin\AdminProductSizeController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Admin\AdminSliderController;
use App\Http\Controllers\Admin\AdminWhyChooseController;
use App\Http\Controllers\Front\CustomerAuthController;
use App\Http\Controllers\Front\FrontCartController;
use App\Http\Controllers\Front\FrontCheckoutController;
use App\Http\Controllers\Front\FrontCouponController;
use App\Http\Controllers\Front\FrontCustomerProfileController;
use App\Http\Controllers\Front\FrontHomeController;
use App\Http\Controllers\Front\FrontOrderController;
use App\Http\Controllers\Front\FrontPaymentController;
use App\Http\Controllers\Front\FrontProductController;


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

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
    Route::get("settings",[AdminSettingController::class,"settings"])->name("admin.settings");
    Route::post("settings/update",[AdminSettingController::class,"settings_update"])->name("admin.settings.update");
    Route::post("setting/slider/update",[AdminSettingController::class,"slider_update"])->name("admin.setting.slider.update");
    Route::post("setting/why-chooser/update",[AdminSettingController::class,"why_choose_update"])->name("admin.setting.why_chooser.update");
    Route::get("setting/menu",[AdminSettingController::class,"menu"])->name("admin.setting.menu");
    Route::post("setting/menu/update",[AdminSettingController::class,"menu_update"])->name("admin.setting.menu.update");

    /* settings - slider */
    Route::get("setting/slides",[AdminSliderController::class,"slides"])->name("admin.setting.slides");
    Route::get("setting/slide/add",[AdminSliderController::class,"slides_add"])->name("admin.setting.slide.add");
    Route::get("setting/slide/edit/{slide_id}",[AdminSliderController::class,"slides_edit"])->name("admin.setting.slide.edit");
    Route::post("setting/slide/store",[AdminSliderController::class,"slides_store"])->name("admin.setting.slide.store");
    Route::post("setting/slide/update",[AdminSliderController::class,"slides_update"])->name("admin.setting.slide.update");
    Route::post("setting/slide/status/update",[AdminSliderController::class,"slides_status_update"])->name("admin.setting.slide.status.update");
    Route::post("setting/slide/delete",[AdminSliderController::class,"slides_delete"])->name("admin.setting.slide.delete");

    /*settings -  why choose */
    Route::get("setting/why-chooses",[AdminWhyChooseController::class,"why_chooses"])->name("admin.setting.why_chooses");
    Route::get("setting/why-choose/add",[AdminWhyChooseController::class,"why_choose_add"])->name("admin.setting.why_choose.add");
    Route::get("setting/why-choose/edit/{why_choose_id}",[AdminWhyChooseController::class,"why_choose_edit"])->name("admin.setting.why_choose.edit");
    Route::post("setting/why-choose/store",[AdminWhyChooseController::class,"why_choose_store"])->name("admin.setting.why_choose.store");
    Route::post("setting/why-choose/update",[AdminWhyChooseController::class,"why_choose_update"])->name("admin.setting.why_choose.update");
    Route::post("setting/why-choose/status/update",[AdminWhyChooseController::class,"why_choose_status_update"])->name("admin.setting.why_choose.status.update");
    Route::post("setting/why-choose/delete",[AdminWhyChooseController::class,"why_choose_delete"])->name("admin.setting.why_choose.delete");  

    /* categories */
    Route::get("categories",[AdminCategoryController::class,"categories"])->name("admin.categories");
    Route::get("category/add",[AdminCategoryController::class,"category_add"])->name("admin.category.add");
    Route::get("category/edit/{category_id}",[AdminCategoryController::class,"category_edit"])->name("admin.category.edit");
    Route::post("category/store",[AdminCategoryController::class,"category_store"])->name("admin.category.store");
    Route::post("category/update",[AdminCategoryController::class,"category_update"])->name("admin.category.update");
    Route::post("category/status/update",[AdminCategoryController::class,"category_status_update"])->name("admin.category.status.update");
    Route::post("category/home/update",[AdminCategoryController::class,"category_home_update"])->name("admin.category.home.update");
    Route::post("category/delete",[AdminCategoryController::class,"category_delete"])->name("admin.category.delete");

    /* delivery areas */
    Route::get("delivery-areas",[AdminDeliveryAreasController::class,"delivery_areas"])->name("admin.delivery_areas");
    Route::get("delivery-area/add",[AdminDeliveryAreasController::class,"delivery_area_add"])->name("admin.delivery_area.add");
    Route::get("delivery-area/edit/{delivery_area_id}",[AdminDeliveryAreasController::class,"delivery_area_edit"])->name("admin.delivery_area.edit");
    Route::post("delivery-area/store",[AdminDeliveryAreasController::class,"delivery_area_store"])->name("admin.delivery_area.store");
    Route::post("delivery-area/update",[AdminDeliveryAreasController::class,"delivery_area_update"])->name("admin.delivery_area.update");
    Route::post("delivery-area/ajax/status/update",[AdminDeliveryAreasController::class,"delivery_area_ajax_status_update"])
        ->name("admin.delivery_area.ajax.status.update");
    Route::post("delivery-area/ajax/delete",[AdminDeliveryAreasController::class,"delivery_area_ajax_delete"])->name("admin.delivery_area.ajax.delete");

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

    /* options */
    Route::get("options",[AdminOptionController::class,"options"])->name("admin.options");
    Route::get("option/add",[AdminOptionController::class,"option_add"])->name("admin.option.add");
    Route::get("option/edit/{option_id}",[AdminOptionController::class,"option_edit"])->name("admin.option.edit");
    Route::post("option/store",[AdminOptionController::class,"option_store"])->name("admin.option.store");
    Route::post("option/update",[AdminOptionController::class,"option_update"])->name("admin.option.update");
    Route::post("option/status/update",[AdminOptionController::class,"option_status_update"])->name("admin.option.status.update");
    Route::post("option/delete",[AdminOptionController::class,"option_delete"])->name("admin.option.delete");

    /* coupons */
    Route::get("coupons",[AdminCouponController::class,"coupons"])->name("admin.coupons");
    Route::get("coupon/add",[AdminCouponController::class,"coupon_add"])->name("admin.coupon.add");
    Route::get("coupon/edit/{coupon_id}",[AdminCouponController::class,"coupon_edit"])->name("admin.coupon.edit");
    Route::post("coupon/store",[AdminCouponController::class,"coupon_store"])->name("admin.coupon.store");
    Route::post("coupon/update",[AdminCouponController::class,"coupon_update"])->name("admin.coupon.update");
    Route::post("coupon/ajax/status/update",[AdminCouponController::class,"coupon_ajax_status_update"])->name("admin.coupon.ajax.status.update");
    Route::post("coupon/ajax/delete",[AdminCouponController::class,"coupon_ajax_delete"])->name("admin.coupon.ajax.delete");

    /* payments */
    Route::get("payment/paypal/edit",[AdminPaymentController::class,"payment_paypal_edit"])->name("admin.payment.paypal.edit");
    Route::get("payment/stripe/edit",[AdminPaymentController::class,"payment_stripe_edit"])->name("admin.payment.stripe.edit");
    Route::get("payment/razorpay/edit",[AdminPaymentController::class,"payment_razorpay_edit"])->name("admin.payment.razorpay.edit");
    Route::post("payment/paypal/update",[AdminPaymentController::class,"payment_paypal_update"])->name("admin.payment.paypal.update");
    Route::post("payment/stripe/update",[AdminPaymentController::class,"payment_stripe_update"])->name("admin.payment.stripe.update");
    Route::post("payment/razorpay/update",[AdminPaymentController::class,"payment_razorpay_update"])->name("admin.payment.razorpay.update");
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
    Route::post("password/update",[FrontCustomerProfileController::class,"password_update"])->name("front.customer.password.update");
    Route::get("profile/edit/ajax",[FrontCustomerProfileController::class,"profile_edit_ajax"])->name("front.customer.profile.edit.ajax");
    Route::post("profile/update/ajax",[FrontCustomerProfileController::class,"profile_update_ajax"])->name("front.customer.profile.update.ajax");
    Route::get("profile/info/ajax",[FrontCustomerProfileController::class,"profile_info_ajax"])->name("front.customer.profile.info.ajax");
    Route::post("address/store/ajax",[FrontCustomerProfileController::class,"address_store_ajax"])->name("front.customer.address.store.ajax");
    Route::get("address/items/ajax",[FrontCustomerProfileController::class,"address_items_ajax"])->name("front.customer.address.items.ajax");
    Route::post("address/edit/ajax",[FrontCustomerProfileController::class,"address_edit_ajax"])->name("front.customer.address.edit.ajax");
    Route::post("address/update/ajax",[FrontCustomerProfileController::class,"address_update_ajax"])->name("front.customer.address.update.ajax");
    Route::post("address/delete/ajax",[FrontCustomerProfileController::class,"address_delete_ajax"])->name("front.customer.address.delete.ajax");
});


/* ********** FRONT *********** */


Route::prefix("/")->group(function(){
    /* base */
    Route::get("",[FrontHomeController::class,"index"])->name("front.index");

    /* product */
    Route::get("products",[FrontProductController::class,"products"])->name("front.products");
    Route::get("product/{product_id}/{product_slug}",[FrontProductController::class,"product"])->name("front.product");

    /* order - cart */
    Route::get("order/cart",[FrontCartController::class,"cart"])->name("front.order.cart");
    Route::post("order/popup/ajax/submit",[FrontCartController::class,"cart_ajax_popup"])->name("front.order.popup.ajax.submit");
    Route::post("order/cart/ajax/submit",[FrontCartController::class,"cart_ajax_submit"])->name("front.order.cart.ajax.submit");
    Route::get("order/cart/ajax/count",[FrontCartController::class,"cart_ajax_count"])->name("front.order.cart.ajax.count");
    Route::get("order/cart/ajax/items",[FrontCartController::class,"cart_ajax_items"])->name("front.order.cart.ajax.items");
    Route::get("order/cart/ajax/page",[FrontCartController::class,"cart_ajax_page"])->name("front.order.cart.ajax.page");
    Route::post("order/cart/ajax/item/remove",[FrontCartController::class,"cart_ajax_item_remove"])->name("front.order.cart.ajax.item.remove");
    Route::get("order/cart/ajax/items/remove",[FrontCartController::class,"cart_ajax_items_remove"])->name("front.order.cart.ajax.items.remove");
    Route::post("order/cart/ajax/quantity",[FrontCartController::class,"cart_ajax_quantity"])->name("front.order.cart.ajax.quantity");
    
    /* order - coupon */
    Route::post("order/coupon/ajax/submit",[FrontCouponController::class,"coupon_ajax_submit"])->name("front.order.coupon.ajax.submit");
    Route::get("order/coupon/ajax/remove",[FrontCouponController::class,"coupon_ajax_remove"])->name("front.order.coupon.ajax.remove");

    Route::middleware("customer.checkout")->group(function () {
        /* order - checkout */
        Route::get("order/checkout",[FrontCheckoutController::class,"checkout_view"])->name("front.order.checkout.view");
        Route::get("order/checkout/view/ajax/page",[FrontCheckoutController::class,"checkout_view_ajax_page"])->name("front.order.checkout.view.ajax.page");
        Route::post("order/checkout/store/ajax/address",[FrontCheckoutController::class,"checkout_store_ajax_address"])->name("front.order.checkout.store.ajax.address");
        Route::post("order/checkout/store/ajax/addresses",[FrontCheckoutController::class,"checkout_store_ajax_addresses"])->name("front.order.checkout.store.ajax.addresses");
    });

    Route::middleware("customer.checkout","customer.payment")->group(function () {
        /* order - payment */
        Route::get("order/payment",[FrontPaymentController::class,"payment_view"])->name("front.order.payment.view");
        Route::post("order/payment/store/ajax",[FrontPaymentController::class,"payment_store_ajax"])->name("front.order.payment.store.ajax");
    });
});


Route::get('/csrf-token-refresh', function () {
    return response()->json(['token' => csrf_token()]);
})->name('csrf.token.refresh');