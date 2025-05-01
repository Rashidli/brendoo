<?php

namespace App\Models;

use App\Traits\LogsActivityTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvantageTranslation extends Model
{
    use HasFactory, LogsActivityTrait;

    public $timestamps = false;
    protected $fillable = ['title'];
}
