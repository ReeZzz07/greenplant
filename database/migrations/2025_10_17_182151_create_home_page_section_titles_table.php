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
        Schema::create('home_page_section_titles', function (Blueprint $table) {
            $table->id();
            $table->string('section_key')->unique()->comment('Ключ секции (products, testimonials, gallery)');
            $table->string('title')->nullable()->comment('Заголовок секции');
            $table->text('subtitle')->nullable()->comment('Подзаголовок секции');
            $table->boolean('is_active')->default(true)->comment('Активность секции');
            $table->integer('order')->default(0)->comment('Порядок сортировки');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_page_section_titles');
    }
};
