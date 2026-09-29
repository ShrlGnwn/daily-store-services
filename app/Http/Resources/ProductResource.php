<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'slug' => $this->slug,
            'name' => $this->name,
            'unit' => $this->unit,
            'price' => $this->price,
            'originalPrice' => $this->original_price,
            'categorySlug' => $this->category_slug,
            'images' => $this->images,
            'rating' => $this->rating,
            'stock' => $this->stock,
            'isPopular' => $this->is_popular,
            'description' => $this->description,
        ];
    }
}
