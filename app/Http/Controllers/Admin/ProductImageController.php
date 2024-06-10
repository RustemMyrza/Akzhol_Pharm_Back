<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductImage\StoreProductImageRequest;
use App\Http\Requests\Admin\ProductImage\UpdateIsActiveRequest;
use App\Http\Requests\Admin\ProductImage\UpdateProductImageRequest;
use App\Models\Product;
use App\Models\ProductImage;
use App\Services\Admin\ProductImage\ProductImageService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ProductImageController extends Controller
{
    public ProductImageService $service;

    public function __construct(ProductImageService $productImageService)
    {
        $this->service = $productImageService;
    }

    public function index(Product $product)
    {
        $data['productImages'] = $this->service->getProductImages($product);
        $data['product'] = $product;
        return view('admin.productImages.index', $data);
    }

    public function create(Product $product)
    {
        $data['lastPosition'] = ProductImage::lastPosition();
        $data['product'] = $product;
        return view('admin.productImages.create', $data);
    }

    public function store(Product $product, StoreProductImageRequest $request)
    {
        try {
            $this->service->create($product, $request->validated());
            notify()->success('', trans('messages.success_created'));
            return redirect()->route('admin.productImages.index', ['product' => $product]);
        } catch (\Exception $exception) {
            return back()->withErrors($exception->getMessage());
        }
    }

    public function edit(Product $product, ProductImage $productImage)
    {
        $data['lastPosition'] = ProductImage::lastPosition();
        $data['product'] = $product;
        $data['productImage'] = $productImage;
        return view('admin.productImages.edit', $data);
    }

    public function update(Product $product, ProductImage $productImage, UpdateProductImageRequest $request)
    {
        try {
            $this->service->update($product, $productImage, $request->validated());
            notify()->success('', trans('messages.success_updated'));
            return redirect()->route('admin.productImages.index', ['product' => $product]);
        } catch (\Exception $exception) {
            return back()->withErrors($exception->getMessage());
        }
    }

    public function destroy(Product $product, ProductImage $productImage)
    {
        try {
            $this->service->delete($productImage);
            return backPage(trans('messages.success_deleted'));
        } catch (\Exception $exception) {
            return back()->withErrors($exception->getMessage());
        }
    }

    public function updateIsActive(UpdateIsActiveRequest $request, $product): JsonResponse
    {
        try {
            ProductImage::query()
                ->find($request->input('data_id'))
                ->update([
                    'is_active' => $request->input('is_active') == 1 ? 1 : 0
                ]);
            return new JsonResponse(['status' => true]);
        } catch (\Exception $exception) {
            return new JsonResponse(['status' => false, 'message' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
