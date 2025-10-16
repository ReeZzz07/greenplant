<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatalogPageSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'background_image',
        'overlay_type',
        'overlay_opacity',
        'background_position',
        'background_size',
        'title',
        'subtitle',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'overlay_opacity' => 'integer',
    ];

    public function getBackgroundImageUrlAttribute()
    {
        return $this->background_image ? asset('storage/' . $this->background_image) : null;
    }

    public static function getActive()
    {
        return static::where('is_active', true)->first();
    }
}
