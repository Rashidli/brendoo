<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReturnProduct extends Model
{
    use HasFactory;

    protected $fillable = ['order_item_id', 'customer_id', 'quantity', 'status', 'reason'];

    public function orderItem() : BelongsTo
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function customer() : BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
