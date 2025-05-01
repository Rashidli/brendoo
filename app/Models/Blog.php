<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{

    use HasFactory, Translatable, SoftDeletes;
    public $translatedAttributes = [
        'title',
        'description',
        'img_alt',
        'img_title',
        'slug',
        'meta_title',
        'meta_description',
        'meta_keywords'
    ];
    protected $fillable = ['image','is_active','is_new'];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function sliders()
    {
        return $this->morphMany(Slider::class, 'sliderable');
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'blog_service');
    }

}
