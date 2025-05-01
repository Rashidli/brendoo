<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notice extends Model
{

    use HasFactory, SoftDeletes;
    protected $fillable = ['title', 'body', 'customer_id', 'is_read'];

    protected $casts = [
        'is_read' => 'boolean'
    ];

}
