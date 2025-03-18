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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            $table->integer("order_id");
            $table->string("product_id");
            $table->string("product_name");
            $table->double("price");
            $table->integer("qty");
            $table->json("product_size")->nullable();
            $table->json("product_option")->nullable();

            $table->foreign("order_id")->references("id")->on("orders")->onDelete("restrict")->onUpdate("cascade");
            $table->foreign("product_id")->references("id")->on("products")->onDelete("restrict")->onUpdate("cascade");
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
