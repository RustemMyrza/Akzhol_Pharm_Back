<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'address' => $this->addressTranslate?->{$request->language},
            'phone' => $this->phone,
            'phone_2' => $this->phone_2,
            'email' => $this->email,
            'map_link' => $this->map_link,
        ];
    }
}
