<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class FilterResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->titleTranslate?->{$request->language},
            'filter_items' => FilterItemResource::collection($this->filterItems)
        ];
    }
}
