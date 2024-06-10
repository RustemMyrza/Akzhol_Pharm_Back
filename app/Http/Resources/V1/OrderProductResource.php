<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderProductResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->product ? $this->product->titleTranslate?->{$request->language} : $this->product_name,
            'image' => $this->product ? $this->product->image_url : $this->default_product_image_url,
            'vendor_code' => $this->product ? $this->product->vendor_code : $this->vendor_code,
            'price' => $this->price,
            'status' => $this->order->status,
            'status_name' => $this->order->status_name
        ];
    }
}
