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
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("category_id");
            $table->text("options")->nullable();
            $table->string("name");
            $table->string("slug");
            $table->double("price");
            $table->double("offer_price")->default(0);
            $table->string("sku")->unique()->nullable();
            $table->string("seo_title")->nullable();
            $table->text("seo_description")->nullable();
            $table->string("image");
            $table->text("description");
            $table->string("short_description")->nullable();
            $table->boolean("status")->default(0);
            $table->boolean("show_on_homepage")->default(0);

            $table->timestamps();

            $table->foreign("category_id")->references("id")->on("categories")->onDelete("restrict")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
