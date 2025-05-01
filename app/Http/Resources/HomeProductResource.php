<?php

namespace App\Http\Resources;

use App\Models\Filter;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HomeProductResource extends JsonResource
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
            'is_new' => $this->is_new,
            'is_season' => $this->is_season,
            'slug' =>
                [
                    'en' => $this->translate('en')->slug,
                    'ru' => $this->translate('ru')->slug,
                ],
            'price' => $this->price,
            'discount' => $this->discount,
            'sliders' => SliderResource::collection($this->sliders),
            'discounted_price' => $this->discounted_price,
            'image' =>  $this->image,
            'filters' => $this->options
                ->groupBy('pivot.filter_id')
                ->map(function ($options, $filterId) {
                    $filterName = Filter::find($filterId)->title;
                    return [
                        'filter_id' => $filterId,
                        'filter_name' => $filterName,
                        'options' => $options->map(function ($option) {
                            return [
                                'option_id' => $option->id,
                                'name' => $option->title,
                                'is_default' => $option->pivot->is_default,
                                'color_code' => $option->color_code
                            ];
                        })->toArray(),
                    ];
                })->values()->toArray(),
        ];
    }
}
