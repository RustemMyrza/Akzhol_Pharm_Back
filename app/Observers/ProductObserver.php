<?php

namespace App\Observers;

use App\Models\Category;
use App\Models\Product;

class ProductObserver
{
    public function saved(Product $product)
    {
        $this->updateStatusByStockQuantity($product);
        $this->forgetCaches();
    }

    public function created(Product $product)
    {
        $this->updateStatusByStockQuantity($product);
        $this->forgetCaches();
    }

    public function updated(Product $product)
    {
        $this->updateStatusByStockQuantity($product);
        $this->forgetCaches();
    }

    public function deleted()
    {
        $this->forgetCaches();
    }

    protected function updateStatusByStockQuantity(Product $product)
    {
        if ($product->stock_quantity == 0) {
            $product->status = 0;
        }
    }

    protected function forgetCaches()
    {
        cache()->forget('apiNewCategories');
        cache()->forget('apiImportantCategory');
        cache()->forget('productsCount');

//        foreach (Product::query()->pluck('slug') as $productSlug) {
//            cache()->forget('apiProduct-' . $productSlug);
//        }

        foreach (Category::query()->pluck('id') as $categoryId) {
            cache()->forget('apiSimilarProducts-' . $categoryId);
        }
    }
}
