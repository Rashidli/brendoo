<?php

namespace App\Models;

use App\Traits\LogsActivityTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RegisterImage extends Model
{
    use HasFactory, SoftDeletes,LogsActivityTrait;
    protected $guarded = [];
}
