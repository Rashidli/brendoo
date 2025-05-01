<?php

namespace App\Models;

use App\Traits\LogsActivityTrait;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{

    use HasFactory, Translatable, SoftDeletes,LogsActivityTrait;

    public $translatedAttributes = ['title'];

    protected $fillable = ['image','is_home'];

    public function filters() : BelongsToMany
    {
        return $this->belongsToMany(Filter::class);
    }

    public function subCategories() : HasMany
    {
        return $this->hasMany(SubCategory::class);
    }

    public function products() : HasMany
    {
        return $this->hasMany(Product::class);
    }

}
