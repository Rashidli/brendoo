<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'barcode', 'weight',
        'status','waybill_path',
        'tr_barcode','top_delivery_order_id',
        'topdelivery_waybill_path','webshop_number'];

    public function orderItems()
    {
        return $this->belongsToMany(OrderItem::class);
    }

    public function boxes()
    {
        return $this->belongsToMany(Box::class, 'box_packages');
    }

}
