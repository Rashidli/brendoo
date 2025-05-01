<?php

namespace App\Models;

use App\Traits\LogsActivityTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HolidayBannerTranslation extends Model
{

    use HasFactory, LogsActivityTrait;

    public $timestamps = false;

    protected $fillable = ['title','description','holiday_banner_id','locale','value'];

}
