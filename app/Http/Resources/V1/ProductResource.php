<?php

namespace App\Http\Resources\V1;

//use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;
//use Illuminate\Support\Facades\Storage;

class ProductResource extends JsonResource
{
    public function toArray($request): array
    {
        $images = ProductImageResource::collection($this->productImages)->toArray($request);
        array_unshift($images, ['image' => $this->image_url]);

        return [
            'id' => $this->id,
            'title' => $this->titleTranslate?->{$request->language},

            'vendor_code' => $this->vendor_code,
            'slug' => $this->slug,
            'image' => $this->image_url,
            'document' => $this->document_url,
            'images' => $images,
            'youtube_link' => $this->youtube_link ?? null,
            'price' => $this->price_format,
            'old_price' => $this->old_price_format,
//            'bulk_price' => $this->bulk_price,
//            'stock_quantity' => $this->stock_quantity,
            'discount' => $this->discount,
            'category_id' => $this->category_id,
            'category_name' => $this->category?->titleTranslate?->{$request->language},
            'status' => $this->status,
            'status_name' => $this->status_name,
            'productFeatureItems' => new ProductFeatureItemCollection($this->productFeatureItems),
//            'feature_image' => $this->feature_image_url,

            'description' => $this->descriptionTranslate?->{$request->language},
//            'description_lists' => !empty($this->description_lists)
//                ? $this->getLists($this->description_lists[$request->language])
//                : null,

            'instruction' => $this->instructionTranslate?->{$request->language},
//            'instruction_lists' => !empty($this->instruction_lists)
//                ? $this->getLists($this->instruction_lists[$request->language])
//                : null,

//            'specification_table' => $this->specificationTableTranslate?->{$request->language},  // Технические характеристики
//
//            'size_image' => $this->size_image_url, // Основные размеры

//            'collapsible_diagram' => $this->collapsible_diagram  // Разборная схема
//                ? $this->getDiagram($this->collapsible_diagram[$request->language])
//                : null,

//            'installation_image' => $this->installation_image_url,  // Схема установки
        ];
    }

//    private function getLists(array $arrayLists)
//    {
//        return array_map(function ($item) {
//            if (isset($item['image'])) {
//                $item['image'] = !is_null($item['image']) ? $this->getImageUrl($item['image']) : null;
//            }
//            return $item;
//        }, $arrayLists);
//    }
//
//    private function getDiagram(array $collapsibleDiagram)
//    {
//        if (!is_null($collapsibleDiagram['table']) && !is_null($collapsibleDiagram['image'])) {
//            return [
//                'image' => !is_null($collapsibleDiagram['image']) ? $this->getImageUrl($collapsibleDiagram['image']) : null,
//                'table' => $collapsibleDiagram['table']
//            ];
//        }
//        return null;
//    }

//    private function getImageUrl(string $image): ?string
//    {
//        return $image
//            ? Storage::disk('custom')->url(Product::IMAGE_PATH . '/' . $image)
//            : null;
//    }
}
