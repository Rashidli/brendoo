<?php

namespace App\Models;

use App\Traits\LogsActivityTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SingleTranslation extends Model
{
    use HasFactory,LogsActivityTrait;

    public $timestamps = false;
    protected $fillable = ['title','seo_description','seo_title','single_id','locale','slug','seo_keywords'];
}
