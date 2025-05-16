<?php

namespace App\Models;

use App\Traits\LogsActivityTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTranslation extends Model
{
    use HasFactory, LogsActivityTrait;

    public $timestamps = false;
    protected $fillable = [
        'title',
        'description',
        'short_description',
        'blog_id',
        'locale',
        'img_alt',
        'img_title',
        'slug',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'short_title'
    ];
}
