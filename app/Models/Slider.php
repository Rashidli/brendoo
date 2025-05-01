<?php

namespace App\Models;

use App\Traits\LogsActivityTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory,LogsActivityTrait;
    protected $guarded = [];
    public function slidable()
    {
        return $this->morphTo();
    }
}
