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
        Schema::table('contact_page_settings', function (Blueprint $table) {
            $table->string('contact_section_title')->default('Свяжитесь с нами')->after('map_embed_code');
            $table->text('contact_section_content')->nullable()->after('contact_section_title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contact_page_settings', function (Blueprint $table) {
            $table->dropColumn(['contact_section_title', 'contact_section_content']);
        });
    }
};
