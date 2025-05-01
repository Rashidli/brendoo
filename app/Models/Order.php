<?php

namespace App\Models;

use App\Notifications\OrderStatusUpdated;
use App\Traits\LogsActivityTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes,LogsActivityTrait;

    protected $guarded = [];

    public function customer() : BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function order_items() : HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function coupons() : BelongsToMany
    {
        return $this->belongsToMany(Coupon::class, 'coupon_order');
    }

    protected static function boot()
    {
        parent::boot();

        static::updated(function ($order) {
            if ($order->isDirty('status')) {
                Notice::create([
                    'title'       => 'Order Status Updated',
                    'body'        => "Your order #{$order->id} status has been updated to {$order->status}.",
                    'customer_id' => $order->customer_id,
                    'is_read'     => false,
                ]);
            }
        });
    }
}
