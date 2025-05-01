<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockNotification extends Model
{

    use HasFactory;

    protected $fillable = ['product_id', 'option_id', 'customer_id','notified'];

    public function product() : BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function customer() : BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function option() : BelongsTo
    {
        return $this->belongsTo(Option::class);
    }

}
