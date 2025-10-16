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
        Schema::create('hero_settings', function (Blueprint $table) {
            $table->id();
            $table->string('background_image')->nullable(); // Путь к фоновому изображению
            $table->string('overlay_type')->default('darken'); // Тип наложения: darken, lighten, none
            $table->integer('overlay_opacity')->default(50); // Прозрачность наложения (0-100)
            $table->string('background_color')->default('#82ae46'); // Цвет фона по умолчанию
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hero_settings');
    }
};
