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
        Schema::table('home_page_features', function (Blueprint $table) {
            $table->string('icon_size')->default('48px')->after('icon_type'); // Размер иконки в пикселях
            $table->string('icon_color')->nullable()->after('icon_size'); // Цвет иконки (hex)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('home_page_features', function (Blueprint $table) {
            $table->dropColumn(['icon_size', 'icon_color']);
        });
    }
};
