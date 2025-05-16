<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnBoardingTranslation extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['title','main_id','locale','sub_title'];
}
