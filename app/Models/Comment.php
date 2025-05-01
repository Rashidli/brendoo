<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{

    use HasFactory, SoftDeletes;
    protected $guarded = [];

    public function customer() : BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function product() : BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

}
