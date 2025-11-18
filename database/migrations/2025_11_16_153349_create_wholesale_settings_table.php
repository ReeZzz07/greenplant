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
        Schema::create('wholesale_settings', function (Blueprint $table) {
            $table->id();
            // Hero секция
            $table->string('background_image')->nullable();
            $table->string('overlay_type')->default('none'); // none, darken, lighten
            $table->integer('overlay_opacity')->default(50); // 0-100
            $table->string('background_position')->default('center center');
            $table->string('background_size')->default('cover');
            $table->string('background_color')->default('#82ae46');
            $table->string('title')->default('Оптовым покупателям');
            $table->text('subtitle')->nullable();
            // Настройки калькулятора
            $table->decimal('purchase_price', 10, 2)->default(1200.00); // Цена закупки за штуку
            $table->decimal('default_sale_price', 10, 2)->default(2500.00); // Средняя цена продажи по умолчанию
            $table->integer('min_quantity')->default(50); // Минимальное количество для опта
            $table->text('calculator_description')->nullable(); // Описание под калькулятором
            // Основной контент
            $table->text('advantages')->nullable(); // JSON с преимуществами
            $table->text('how_it_works')->nullable(); // JSON с пошаговой инструкцией
            $table->text('testimonials')->nullable(); // JSON с отзывами партнеров
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wholesale_settings');
    }
};
