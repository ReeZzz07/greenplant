<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'short_description',
        'price',
        'old_price',
        'category_id',
        'image',
        'images',
        'hero_background_image',
        'hero_background_position',
        'hero_background_size',
        'hero_background_color',
        'hero_overlay_type',
        'hero_overlay_opacity',
        'is_active',
        'is_featured',
        'stock',
        'sku',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'old_price' => 'decimal:2',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'images' => 'array',
        'hero_overlay_opacity' => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getFirstImageAttribute(): ?string
    {
        if (!empty($this->attributes['image'])) {
            return $this->attributes['image'];
        }

        $images = $this->images ?? [];
        return $images[0] ?? null;
    }

    public function getFirstImageUrlAttribute(): string
    {
        $path = $this->first_image;
        return $path ? asset('storage/' . $path) : asset('assets/images/product-1.png');
    }

    public function getDiscountPercentAttribute()
    {
        if ($this->old_price && $this->old_price > $this->price) {
            return round((($this->old_price - $this->price) / $this->old_price) * 100);
        }
        return 0;
    }

    public function getHeroBackgroundImageUrlAttribute(): ?string
    {
        return $this->hero_background_image
            ? asset('storage/' . $this->hero_background_image)
            : null;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}

