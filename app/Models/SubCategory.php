<?php

namespace App\Models;

use App\Traits\LogsActivityTrait;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubCategory extends Model
{

    use HasFactory, Translatable, SoftDeletes,LogsActivityTrait;
    public $translatedAttributes = ['title'];
    protected $fillable = ['category_id'];

    public function category() : BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function third_categories() : HasMany
    {
        return $this->hasMany(ThirdCategory::class);
    }

}
