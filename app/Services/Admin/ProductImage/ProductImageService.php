<?php

namespace App\Services\Admin\ProductImage;

use App\Models\Product;
use App\Models\ProductImage;
use App\Services\Admin\Service;

class ProductImageService extends Service
{
    public function getProductImages(Product $product)
    {
        return ProductImage::query()
            ->whereProductId($product->id)
            ->orderBy('position')
            ->orderBy('id')
            ->paginate(25);
    }

    public function create(Product $product, array $data)
    {
        return ProductImage::query()
            ->create([
                'product_id' => $product->id,
                'is_active' => $data['is_active'] ?? 0,
                'position' => $data['position'] ?? ProductImage::lastPosition(),
                'image' => $this->fileService->saveFile($data['image'], ProductImage::IMAGE_PATH)
            ]);
    }

    public function update(Product $product, ProductImage $productImage, array $data)
    {
        if (isset($data['image'])) {
            $productImage->image = $this->fileService->saveFile($data['image'], ProductImage::IMAGE_PATH, $productImage->image);
        }
        $productImage->product_id = $product->id;
        $productImage->position = $data['position'] ?? ProductImage::lastPosition();
        $productImage->is_active = $data['is_active'] ?? 0;
        return $productImage->save();
    }

    public function delete(ProductImage $productImage)
    {
        if ($productImage->image) {
            $this->fileService->deleteFile($productImage->image, ProductImage::IMAGE_PATH);
        }
        return $productImage->delete();
    }
}
