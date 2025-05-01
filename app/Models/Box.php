<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Box extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    public function packages()
    {
        return $this->belongsToMany(Package::class, 'box_packages');
    }

}
