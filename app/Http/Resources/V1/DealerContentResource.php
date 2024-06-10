<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class DealerContentResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'description' => $this->descriptionTranslate?->{$request->language},
            'email' => $this->email,
            'phone' => $this->phone,
        ];
    }
}
