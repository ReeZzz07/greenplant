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
        Schema::table('sliders', function (Blueprint $table) {
            $table->integer('image_width')->nullable()->after('image'); // Ширина изображения в пикселях
            $table->integer('image_height')->nullable()->after('image_width'); // Высота изображения в пикселях
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->dropColumn(['image_width', 'image_height']);
        });
    }
};
