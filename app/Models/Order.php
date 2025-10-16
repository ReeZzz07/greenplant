<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_address',
        'customer_comment',
        'total_amount',
        'status',
        'payment_method',
        'delivery_method',
        'ip_address',
    ];

    protected $casts = [
        'total_amount' => 'float',
    ];

    /**
     * Пользователь, создавший заказ
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Позиции заказа
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeProcessing($query)
    {
        return $query->where('status', 'processing');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public static function generateOrderNumber()
    {
        return 'GP-' . date('Ymd') . '-' . str_pad(static::whereDate('created_at', today())->count() + 1, 4, '0', STR_PAD_LEFT);
    }
}

