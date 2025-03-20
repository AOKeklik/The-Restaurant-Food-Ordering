<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * 
     * paypal_logo
     * paypal_status
     * paypal_account_mode
     * paypal_country
     * paypal_currency
     * paypal_rate
     * paypal_api_key
     * paypal_secret_key
     * paypal_app_id
     * stripe_logo
     * stripe_status
     * stripe_country
     * stripe_currency
     * stripe_rate
     * stripe_api_key
     * stripe_secret_key
     * razorpay_status
     * razorpay_country
     * razorpay_currency
     * razorpay_rate
     * razorpay_api_key
     * razorpay_secret_key
     * razorpay_logo
     * 
     * 
     * 
     */
    public function up(): void
    {
        Schema::create('payment_settings', function (Blueprint $table) {
            $table->id();
            $table->string("key");
            $table->text("value");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_settings');
    }
};
