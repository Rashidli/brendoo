<?php

namespace App\Models;

use App\Traits\LogsActivityTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefundTranslation extends Model
{
    use HasFactory,LogsActivityTrait;

    public $timestamps = false;
    protected $fillable = ['title','description','refund_id','locale'];
}
