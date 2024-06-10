<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->titleTranslate?->{$request->language},
            'image' => $this->image_url,
            'plural_title' => $this->pluralTitleTranslate?->{$request->language},
            'filters' => FilterResource::collection($this->categoryFilters),
            'is_new' => $this->is_new,
            'subCategories' => count($this->subCategories) ? SubCategoryResource::collection($this->subCategories) : null
        ];
    }
}
