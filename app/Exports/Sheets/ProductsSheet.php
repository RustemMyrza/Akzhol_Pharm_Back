<?php

namespace App\Exports\Sheets;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ProductsSheet implements FromView, WithTitle, ShouldAutoSize
{
    public function view(): View
    {
        $products = Product::query()
            ->withTranslations()
            ->with(['category', 'productFilterItems', 'productFeatureItems'])
            ->limit(2)
            ->get()
            ->transform(function ($product) {
                return [
                    'titleRu' => $product->titleTranslate?->ru,
                    'titleEn' => $product->titleTranslate?->en,
                    'descriptionRu' => $product->descriptionTranslate?->ru,
                    'descriptionEn' => $product->descriptionTranslate?->en,
                    'instructionRu' => $product->instructionTranslate?->ru,
                    'instructionEn' => $product->instructionTranslate?->en,
                    'vendorCode' => $product->vendor_code,
                    'price' => $product->price,
                    'discount' => $product->discount,
//                    'bulkPrice' => $product->bulk_price,
//                    'stockQuantity' => $product->stock_quantity,
                    'status' => $product->status,
                    'categoryId' => $product->category_id,
                    'subCategoryId' => $product->sub_category_id,
                    'productFilterItems' => $product->productFilterItems?->pluck('id')->implode(','),
                    'productFeatureItems' => $product->productFeatureItems?->pluck('id')->implode(',')
                ];
            });
        return view('admin.exports.productSheet', ['products' => $products]);
    }

    public function title(): string
    {
        return 'Товары';
    }
}
