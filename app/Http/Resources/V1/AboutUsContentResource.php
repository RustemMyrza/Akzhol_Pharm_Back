<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class AboutUsContentResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'description' => $this->descriptionTranslate?->{$request->language},
            'content' => $this->contentTranslate?->{$request->language},
            'image' => $this->image ? url($this->image) : null,
        ];
    }
}
