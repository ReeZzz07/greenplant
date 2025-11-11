<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductHeroSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'background_image',
        'background_position',
        'background_size',
        'overlay_type',
        'overlay_opacity',
        'background_color',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'overlay_opacity' => 'integer',
    ];

    public static function getSettings(): self
    {
        return static::firstOrCreate([], [
            'background_position' => 'center center',
            'background_size' => 'cover',
            'overlay_type' => 'darken',
            'overlay_opacity' => 50,
            'background_color' => '#82ae46',
            'is_active' => true,
        ]);
    }
}


