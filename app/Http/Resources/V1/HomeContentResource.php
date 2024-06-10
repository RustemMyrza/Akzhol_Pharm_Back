<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class HomeContentResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'title' => $this->titleTranslate?->{$request->language},
            'description' => $this->descriptionTranslate?->{$request->language},
        ];
    }
}
