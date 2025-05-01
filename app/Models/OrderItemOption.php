<?php

namespace App\Models;

use App\Traits\LogsActivityTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItemOption extends Model
{
    use HasFactory,LogsActivityTrait;
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
