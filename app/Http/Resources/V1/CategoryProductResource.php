<?php

namespace App\Http\Resources\V1;

use App\Models\UserFavorite;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryProductResource extends JsonResource
{
    public function toArray($request): array
    {
        $isFavorite = 0;
        if ($request->user()) {
            $isFavorite = (int) UserFavorite::query()
                ->where('user_id', '=', $request->user()->id)
                ->where('product_id', '=', $this->id)
                ->exists();
        }

        return [
            'id' => $this->id,
            'title' => $this->titleTranslate?->{$request->language},
            'vendor_code' => $this->vendor_code,
            'slug' => $this->slug,
            'image' => $this->image_url,
            'price' => $this->price_format,
            'old_price' => $this->old_price_format,
            'stock_quantity' => $this->stock_quantity,
            'discount' => $this->discount,
            'status' => $this->status,
            'status_name' => $this->status_name,
            'is_favorite' => $isFavorite
        ];
    }
}
