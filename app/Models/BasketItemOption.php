<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class BasketItemOption extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function filter(): BelongsTo
    {
        return $this->belongsTo(Filter::class);
    }

    public function option() : BelongsTo
    {
        return $this->belongsTo(Option::class);
    }
}
