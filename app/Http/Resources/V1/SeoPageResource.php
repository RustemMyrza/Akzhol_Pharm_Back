<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;
class SeoPageResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'meta_title' => $this->metaTitleTranslate?->{$request->language},
            'meta_description' => $this->metaDescriptionTranslate?->{$request->language},
            'meta_keyword' => $this->metaKeywordTranslate?->{$request->language},
        ];
    }
}
