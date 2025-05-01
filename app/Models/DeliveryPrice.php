<?php

namespace App\Models;

use App\Traits\LogsActivityTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryPrice extends Model
{
    use HasFactory, LogsActivityTrait;

    protected $guarded = [];
}
