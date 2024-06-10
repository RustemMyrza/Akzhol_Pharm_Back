<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\UpdateProductSeoRequest;
use App\Models\Product;
use App\Services\Admin\Product\ProductService;
use Illuminate\Support\Facades\DB;

class ProductSeoController extends Controller
{
    public ProductService $service;

    public function __construct(ProductService $productService)
    {
        $this->service = $productService;
    }

    public function edit(Product $product)
    {
        $data['product'] = $product->load('metaTitleTranslate', 'metaDescriptionTranslate', 'metaKeywordTranslate');
        return view('admin.products.editSeo', $data);
    }

    public function update(Product $product, UpdateProductSeoRequest $request)
    {
        try {
            return DB::transaction(function () use ($product, $request) {
                 $this->service->updateSeo($product, $request->validated());
                return backPage(trans('messages.success_updated'));
            });
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }
}
