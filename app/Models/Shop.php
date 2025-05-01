<?php

namespace App\Models;

use App\Traits\LogsActivityTrait;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shop extends Model
{

    use HasFactory, Translatable, SoftDeletes,LogsActivityTrait;
    public $translatedAttributes = ['title','address'];
    protected $fillable = ['is_active'];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

}
