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
        Schema::table('account_page_settings', function (Blueprint $table) {
            // Удаляем старую структуру и создаем новую
        });
        
        // Пересоздаем таблицу с правильной структурой
        Schema::dropIfExists('account_page_settings');
        Schema::create('account_page_settings', function (Blueprint $table) {
            $table->id();
            $table->string('hero_background_image')->nullable();
            $table->string('overlay_type')->default('none'); // none, darken, lighten
            $table->integer('overlay_opacity')->default(50); // 0-100
            $table->string('background_position')->default('center center');
            $table->string('background_size')->default('cover'); // cover, contain, auto, 100% 100%
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_page_settings');
        Schema::create('account_page_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });
    }
};
