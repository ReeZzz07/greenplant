<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('label')->default('Дом'); // Дом, Работа, Другой
            $table->string('full_name');
            $table->string('phone');
            $table->string('city');
            $table->string('address'); // Улица, дом, квартира
            $table->string('postal_code')->nullable();
            $table->text('comment')->nullable(); // Комментарий к адресу (подъезд, этаж и т.д.)
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_addresses');
    }
};
