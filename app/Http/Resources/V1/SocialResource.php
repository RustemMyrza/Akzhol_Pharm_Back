<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class SocialResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'link' => $this->link,
            'image' => $this->image_url,
        ];
    }
}
