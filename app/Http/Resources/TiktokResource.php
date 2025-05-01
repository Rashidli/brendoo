<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TiktokResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $base_url = url('/');
        return [
            'id' => $this->id,
            'title' => $this->title,
            'image' => $base_url . '/storage/' . $this->image,
            'products' => SocialProductResource::collection($this->products)
        ];
    }
}
