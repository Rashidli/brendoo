<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    use Translatable;

    public $translatedAttributes = ['title'];
    protected $fillable = ['key'];
}
