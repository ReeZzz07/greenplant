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
        Schema::table('wholesale_settings', function (Blueprint $table) {
            $table->decimal('planting_distance', 5, 2)->default(1.5)->after('min_quantity'); // Расстояние между саженцами в метрах
            $table->decimal('seedling_price', 10, 2)->nullable()->after('planting_distance'); // Цена закупки саженца (можно использовать purchase_price)
            $table->decimal('mature_tree_price', 10, 2)->default(5000.00)->after('seedling_price'); // Цена продажи взрослого дерева через 3 года
            $table->decimal('additional_costs_per_seedling', 10, 2)->default(200.00)->after('mature_tree_price'); // Прочие затраты на один саженец (удобрения, уход)
            $table->integer('maturity_years')->default(3)->after('additional_costs_per_seedling'); // Количество лет до продажи
            $table->decimal('profit_multiplier_min', 3, 1)->default(3.0)->after('maturity_years'); // Минимальный множитель прибыли
            $table->decimal('profit_multiplier_max', 3, 1)->default(4.0)->after('profit_multiplier_min'); // Максимальный множитель прибыли
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wholesale_settings', function (Blueprint $table) {
            $table->dropColumn([
                'planting_distance',
                'seedling_price',
                'mature_tree_price',
                'additional_costs_per_seedling',
                'maturity_years',
                'profit_multiplier_min',
                'profit_multiplier_max',
            ]);
        });
    }
};
