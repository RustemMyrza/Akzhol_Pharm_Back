<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class NewCategoryResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->titleTranslate?->{$request->language},
            'slug' => $this->slug,
            'image' => $this->image_url,
            'products' => CategoryProductResource::collection($this->products)
        ];
    }
}
