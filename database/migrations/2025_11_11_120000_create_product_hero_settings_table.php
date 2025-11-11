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
        Schema::create('product_hero_settings', function (Blueprint $table) {
            $table->id();
            $table->string('background_image')->nullable();
            $table->string('background_position')->default('center center');
            $table->string('background_size')->default('cover');
            $table->string('overlay_type')->default('darken');
            $table->integer('overlay_opacity')->default(50);
            $table->string('background_color')->default('#82ae46');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_hero_settings');
    }
};


