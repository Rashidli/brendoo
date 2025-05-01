<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BasketItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'product' => new ProductResource($this->product),
            'quantity' => $this->quantity,
            'price' => $this->price,
            'options' => $this->options->map(function ($option) {
                return [
                    'filter' => $option->filter?->title,
                    'option' => $option->option?->title,
                ];
            }),
        ];
    }

}
