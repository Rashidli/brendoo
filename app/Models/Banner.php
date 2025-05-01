<?php

namespace App\Models;

use App\Traits\LogsActivityTrait;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
{
    use HasFactory, Translatable, SoftDeletes,LogsActivityTrait;
    public $translatedAttributes = ['title','description'];
    protected $fillable = ['image','is_active','filter_conditions'];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    protected $casts = [
        'filter_conditions' => 'array'
    ];
}
