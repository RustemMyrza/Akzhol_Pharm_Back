<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class SubscriberResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'email' => $this->email,
            'is_news' => $this->is_news,
            'is_sales' => $this->is_sales,
            'is_promotions' => $this->is_promotions,
            'is_active' => $this->is_active,
        ];
    }
}
