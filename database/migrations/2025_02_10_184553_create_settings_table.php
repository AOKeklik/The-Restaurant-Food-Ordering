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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            
            $table->text("slider_photo");
            $table->boolean("slider_status")->default(0);

            $table->string("why_choose_title");
            $table->string("why_choose_sub_title");
            $table->text("why_choose_description");
            $table->boolean("why_choose_status")->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
