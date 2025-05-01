<?php

namespace App\Models;

use App\Traits\LogsActivityTrait;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FaqCategory extends Model
{
    use HasFactory, Translatable, SoftDeletes, LogsActivityTrait;

    public $translatedAttributes = ['title'];

    protected $fillable = ['image','row'];

    public function faqs()
    {
        return $this->hasMany(Faq::class);
    }
}
