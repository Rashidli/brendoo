<?php

namespace App\Models;

use App\Traits\LogsActivityTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialTranslation extends Model
{

    use HasFactory,LogsActivityTrait;

    public $timestamps = false;
    protected $fillable = ['description','special_id','locale','discount'];

}
