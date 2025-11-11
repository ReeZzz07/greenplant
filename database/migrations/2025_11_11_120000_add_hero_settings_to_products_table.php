<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('hero_background_image')->nullable()->after('images');
            $table->string('hero_background_position')->default('center center')->after('hero_background_image');
            $table->string('hero_background_size')->default('cover')->after('hero_background_position');
            $table->string('hero_background_color')->nullable()->after('hero_background_size');
            $table->string('hero_overlay_type')->default('darken')->after('hero_background_color');
            $table->unsignedTinyInteger('hero_overlay_opacity')->default(40)->after('hero_overlay_type');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'hero_background_image',
                'hero_background_position',
                'hero_background_size',
                'hero_background_color',
                'hero_overlay_type',
                'hero_overlay_opacity',
            ]);
        });
    }
};


