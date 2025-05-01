<?php

namespace App\Models;

use App\Traits\LogsActivityTrait;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faq extends Model
{
    use HasFactory, Translatable, SoftDeletes, LogsActivityTrait;

    public $translatedAttributes = ['title','description'];

    protected $fillable = ['is_active','faq_category_id'];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function faq_category() : BelongsTo
    {
        return $this->belongsTo(FaqCategory::class);
    }
}
