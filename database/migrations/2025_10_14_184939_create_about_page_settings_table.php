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
        Schema::create('about_page_settings', function (Blueprint $table) {
            $table->id();
            $table->string('background_image')->nullable();
            $table->string('overlay_type')->default('none');
            $table->integer('overlay_opacity')->default(50);
            $table->string('background_position')->default('center center');
            $table->string('background_size')->default('cover');
            $table->string('title')->default('О компании GreenPlant');
            $table->text('subtitle')->nullable();
            $table->text('main_content')->nullable();
            $table->string('about_image')->nullable();
            $table->text('welcome_title')->nullable();
            $table->text('welcome_text')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_page_settings');
    }
};
