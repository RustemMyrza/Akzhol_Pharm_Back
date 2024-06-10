<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class SliderResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'title' => $this->titleTranslate?->{$request->language},
            'description' => $this->descriptionTranslate?->{$request->language},
            'image' => $this->image_url,
        ];
    }
}
