<?php

namespace App\Models;

use App\Traits\LogsActivityTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Social extends Model
{
    use HasFactory,SoftDeletes,LogsActivityTrait;
    protected $guarded = [];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
