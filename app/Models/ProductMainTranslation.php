<?php

namespace App\Models;

use App\Traits\LogsActivityTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductMainTranslation extends Model
{
    use HasFactory,LogsActivityTrait;

    public $timestamps = false;
    protected $fillable = ['title','product_main_id','locale'];
}
