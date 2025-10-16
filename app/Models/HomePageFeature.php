<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomePageFeature extends Model
{
    use HasFactory;

    protected $fillable = [
        'icon',
        'icon_image',
        'icon_type',
        'icon_size',
        'icon_color',
        'title',
        'description',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    public function getIconImageUrlAttribute()
    {
        return $this->icon_image ? asset('storage/' . $this->icon_image) : null;
    }
}
