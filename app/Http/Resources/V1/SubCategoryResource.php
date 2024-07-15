<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\V1\CategoryProductResource;

class SubCategoryResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->titleTranslate?->{$request->language},
            'products' => $this->getProducts ? CategoryProductResource::collection($this->getProducts) : []
        ];
    }
}
