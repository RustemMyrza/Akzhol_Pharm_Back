<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class HeaderContactResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'phone' => $this->phone,
            'phone_2' => $this->phone_2,
            'email' => $this->email,
        ];
    }
}
