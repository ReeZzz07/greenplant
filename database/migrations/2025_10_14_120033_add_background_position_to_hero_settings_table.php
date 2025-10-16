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
        Schema::table('hero_settings', function (Blueprint $table) {
            $table->string('background_position')->default('center center')->after('background_image'); // Позиция фона: center, top, bottom, left, right, или кастомная
            $table->string('background_size')->default('cover')->after('background_position'); // Размер фона: cover, contain, auto, или кастомный
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hero_settings', function (Blueprint $table) {
            $table->dropColumn(['background_position', 'background_size']);
        });
    }
};
