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

            $table->string("site_name");
            $table->string("site_favicon");
            $table->string("site_top_logo");
            $table->string("site_footer_logo");
            $table->string("site_short_description");
            $table->string("site_currency");
            $table->string("site_currency_icon");
            $table->enum("site_currency_position", ["right","left"]);
            $table->string("site_address");
            $table->string("site_email");
            $table->string("site_phone");

            $table->string("seo_title");
            $table->string("seo_description");
            $table->string("seo_keywords");

            $table->string("link_facebook");
            $table->string("link_linkedin");
            $table->string("link_behance");
            $table->string("link_twitter");
            
            $table->text("slider_photo");
            $table->boolean("slider_status")->default(0);

            $table->string("why_choose_title");
            $table->string("why_choose_sub_title");
            $table->text("why_choose_description");
            $table->boolean("why_choose_status")->default(0);

            $table->string("menu_title");
            $table->string("menu_sub_title");
            $table->text("menu_description");
            $table->boolean("menu_status")->default(0);

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
