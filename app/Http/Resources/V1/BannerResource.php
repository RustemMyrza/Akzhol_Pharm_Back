<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class BannerResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'image' => $this->imageTranslate ? $this->imageUrl($this->imageTranslate, $request->language) : null,
            'mobile_image' => $this->mobileImageTranslate ? $this->imageUrl($this->mobileImageTranslate, $request->language) : null,
        ];
    }
}
