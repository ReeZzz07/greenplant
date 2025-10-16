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
        Schema::table('catalog_page_settings', function (Blueprint $table) {
            $table->string('overlay_type')->default('none')->after('background_image'); // none, darken, lighten
            $table->integer('overlay_opacity')->default(50)->after('overlay_type'); // 0-100
            $table->string('background_position')->default('center center')->after('overlay_opacity');
            $table->string('background_size')->default('cover')->after('background_position');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('catalog_page_settings', function (Blueprint $table) {
            $table->dropColumn(['overlay_type', 'overlay_opacity', 'background_position', 'background_size']);
        });
    }
};
