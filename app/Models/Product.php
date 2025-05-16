<?php

namespace App\Models;

use App\Traits\LogsActivityTrait;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{

    use HasFactory, Translatable, SoftDeletes, LogsActivityTrait;

    public $translatedAttributes = [
        'title',
        'description',
        'short_description',
        'img_alt',
        'img_title',
        'slug',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'short_title',
    ];

//    protected $fillable = ['image','is_active','is_new','category_id'];

    protected $guarded = [];

    protected $casts = [
        'is_new' => 'boolean',
        'is_stock' => 'boolean',
        'is_season' => 'boolean'
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function sliders()
    {
        return $this->morphMany(Slider::class, 'sliderable');
    }

    public function options()
    {
//        return $this->belongsToMany(Option::class, 'product_filter_options')
//            ->withPivot('is_default')
//            ->withTimestamps();
        return $this->belongsToMany(Option::class, 'product_filter_options')
            ->withPivot('filter_id', 'is_default','is_stock');
    }

    public function filters()
    {
        return $this->belongsToMany(Filter::class, 'product_filter_options')
            ->withPivot('is_default','is_stock')
            ->withTimestamps();
    }

    public function category() : BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand() : BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function sub_category() : BelongsTo
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function third_category() : BelongsTo
    {
        return $this->belongsTo(ThirdCategory::class);
    }

    public function tiktoks()
    {
        return $this->morphedByMany(Tiktok::class, 'productable');
    }

    public function instagrams()
    {
        return $this->morphedByMany(Instagram::class, 'productable');
    }

    public function comments() : HasMany
    {
        return $this->hasMany(Comment::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            $lastId = Product::query()->max('id') + 1;
            $product->code = 'PRD-' . str_pad($lastId, 6, '0', STR_PAD_LEFT);
        });
    }

}
