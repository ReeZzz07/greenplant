<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WholesaleSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'background_image',
        'overlay_type',
        'overlay_opacity',
        'background_position',
        'background_size',
        'background_color',
        'title',
        'subtitle',
        'purchase_price',
        'default_sale_price',
        'min_quantity',
        'calculator_description',
        'planting_distance',
        'seedling_price',
        'mature_tree_price',
        'additional_costs_per_seedling',
        'maturity_years',
        'profit_multiplier_min',
        'profit_multiplier_max',
        'advantages',
        'how_it_works',
        'how_it_works_text',
        'testimonials',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'overlay_opacity' => 'integer',
        'min_quantity' => 'integer',
        'maturity_years' => 'integer',
        'purchase_price' => 'decimal:2',
        'default_sale_price' => 'decimal:2',
        'planting_distance' => 'decimal:2',
        'seedling_price' => 'decimal:2',
        'mature_tree_price' => 'decimal:2',
        'additional_costs_per_seedling' => 'decimal:2',
        'profit_multiplier_min' => 'decimal:1',
        'profit_multiplier_max' => 'decimal:1',
        'advantages' => 'array',
        'how_it_works' => 'array',
        'testimonials' => 'array',
    ];

    public function getBackgroundImageUrlAttribute()
    {
        return $this->background_image ? asset('storage/' . $this->background_image) : null;
    }

    public static function getSettings()
    {
        return static::where('is_active', true)->first() ?? new static([
            'title' => 'Оптовым покупателям',
            'purchase_price' => 1200.00,
            'default_sale_price' => 2500.00,
            'min_quantity' => 50,
        ]);
    }
}
