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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("parent_id")->nullable();
            $table->string("name");
            $table->string("slug")->unique();
            $table->enum("type", ["product","page","menu"])->default("product");
            $table->boolean("status")->default(0);
            $table->boolean("show_on_homepage")->default(0);
            $table->foreign("parent_id")->references("id")->on("categories")->onDelete("cascade")->onUpdate("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
