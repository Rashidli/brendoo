<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
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
            'quantity' => $this->quantity,
            'price' => $this->price,
            'status' => $this->status,
            'order_item_status' => $this->order_item_status,
            'product' => new HomeProductResource($this->product),
            'options' => $this->options->map(function ($option) {
                return [
                    'filter' => $option->filter?->title,
                    'option' => $option->option?->title,
                ];
            }),
            'total_price' => $this->quantity * $this->price,
            'statuses' => OrderItemStatusResource::collection($this->statuses)
        ];
    }
}
