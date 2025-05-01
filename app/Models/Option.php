<?php

namespace App\Models;

use App\Traits\LogsActivityTrait;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Option extends Model
{
    use HasFactory, Translatable, SoftDeletes,LogsActivityTrait;
    public $translatedAttributes = ['title'];
    protected $fillable = ['is_active','color_code'];

    protected $casts  = [
      'is_default' => 'boolean'
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function filter()
    {
        return $this->belongsTo(Filter::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_filter_options')
            ->withPivot('is_default')
            ->withTimestamps();
    }

}
