<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HolidayBannerResource extends JsonResource
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
            'value' => $this->value,
            'description' => $this->description,
            'video' => $base_url . '/storage/'.$this->image
        ];
    }
}
