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
            $table->string('icon_image')->nullable()->after('icon'); // Путь к загруженной иконке
            $table->string('icon_type')->default('flaticon')->after('icon_image'); // Тип иконки: flaticon, image, custom
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('home_page_features', function (Blueprint $table) {
            $table->dropColumn(['icon_image', 'icon_type']);
        });
    }
};
