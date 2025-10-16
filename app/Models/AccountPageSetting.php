<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountPageSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'hero_background_image',
        'overlay_type',
        'overlay_opacity',
        'background_position',
        'background_size',
    ];

    /**
     * Получить настройки (создать если не существуют)
     */
    public static function getSettings()
    {
        $settings = static::first();
        
        if (!$settings) {
            $settings = static::create([
                'overlay_type' => 'none',
                'overlay_opacity' => 50,
                'background_position' => 'center center',
                'background_size' => 'cover',
            ]);
        }
        
        return $settings;
    }
}

