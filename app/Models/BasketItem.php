<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BasketItem extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'product_id', 'quantity', 'price'];

    public function customer() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product() : BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function options() : HasMany
    {
        return $this->hasMany(BasketItemOption::class);
    }
}
