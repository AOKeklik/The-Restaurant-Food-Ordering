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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("delivery_area_id");
            $table->enum("type", ["home","office"])->default("home");
            $table->string("first_name");
            $table->string("last_name")->nullable();
            $table->string("email");
            $table->string("phone");
            $table->text("address");

            $table->foreign("user_id")->references("id")->on("user")->onDelete("restrict")->onUpdate("cascade");
            $table->foreign("delivery_area_id")->references("id")->on("delivery_areas")->onDelete("restrict")->onUpdate("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
