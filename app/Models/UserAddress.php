<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'label',
        'full_name',
        'phone',
        'city',
        'address',
        'postal_code',
        'comment',
        'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    /**
     * Связь с пользователем
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Полный адрес одной строкой
     */
    public function getFullAddressAttribute()
    {
        $parts = array_filter([
            $this->city,
            $this->address,
            $this->postal_code ? "Индекс: {$this->postal_code}" : null,
        ]);
        
        return implode(', ', $parts);
    }
}

