<?php

namespace App\Models;

use App\Traits\LogsActivityTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutTranslation extends Model
{

    use HasFactory, LogsActivityTrait;

    public $timestamps = false;
    protected $fillable = ['title','description','about_id','locale','short_title','slug'];


}
