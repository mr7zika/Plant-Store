<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_address',
        'total_amount',
        'status',
    ];

    /**
     * علاقة مع المستخدم
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * علاقة مع منتجات الطلب
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * دالة المراقبة (Events): تعمل تلقائياً عند حذف أو إلغاء الطلب
     */
protected static function booted()
    {
        parent::booted();

        static::deleting(function ($order) {
            foreach ($order->items as $item) {
                \App\Models\Product::where('id', $item->product_id)->increment('quantity', $item->quantity);
            }
        });
    }
}