<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'order_number' => $this->order_number,
            'status' => $this->status,
            'is_deliver' => $this->is_deliver,
            'shop' => $this->shop,
            'payment_type' => $this->payment_type,
            'total_price' => $this->total_price,
            'discount' => $this->discount,
            'delivered_price' => $this->delivered_price,
            'final_price' => $this->final_price,
            'address' => $this->address,
            'additional_info' => $this->additional_info,
            'order_date' => $this->created_at->toDateTimeString(),
//            'updated_at' => $this->updated_at->toDateTimeString(),
            'order_items' => OrderItemResource::collection($this->order_items),
            'order_items_count' => $this->order_items_count
        ];
    }
}
