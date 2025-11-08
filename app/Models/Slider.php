<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'button_text',
        'button_link',
        'image',
        'image_width',
        'image_height',
        'order',
        'is_active',
        'image_position_x',
        'image_position_y',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
        'image_width' => 'integer',
        'image_height' => 'integer',
        'image_position_x' => 'float',
        'image_position_y' => 'float',
    ];

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }
}
