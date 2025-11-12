<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            
            $table->integer("user_id");
            $table->integer("address_id");
   
            $table->string("invoice_id");
            $table->string("transaction_id")->nullable();
            $table->string("payment_method")->nullable();
            $table->enum("payment_status",["pending","success", "cancelled"])->default("pending");
            $table->enum("order_status",["pending","success", "cancelled"])->default("pending");
            $table->timestamp("payment_approve_date")->nullable();
            
            $table->double("discount")->default(0);
            $table->double("delivery_charge")->default(0);
            $table->double("cart_subtotal");
            $table->double("cart_total");
            $table->integer("product_quantity")->default(1);
            $table->json("coupon_info")->nullable();
            $table->text("address");
            $table->string("currency_name")->nullable();   
   
            $table->foreign("user_id")->references("id")->on("users")->onDelete("restrict")->onUpdate("cascade");
            $table->foreign("address_id")->references("id")->on("addresses")->onDelete("restrict")->onUpdate("cascade");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
