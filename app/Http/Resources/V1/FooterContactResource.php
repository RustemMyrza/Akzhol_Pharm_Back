<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class FooterContactResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'phone' => $this->phone,
            'work_time' => $this->workTimeTranslate?->{$request->language},
        ];
    }
}
