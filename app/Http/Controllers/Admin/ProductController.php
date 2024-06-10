<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\StoreProductRequest;
use App\Http\Requests\Admin\Product\UpdateIsActiveRequest;
use App\Http\Requests\Admin\Product\UpdateProductRequest;
use App\Models\Product;
use App\Services\Admin\Product\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public ProductService $service;

    public function __construct(ProductService $productService)
    {
        $this->service = $productService;
    }

    public function index(Request $request)
    {
        try {
            return view('admin.products.index', $this->service->getProducts($request));
        } catch (\Exception $exception) {
            return backPageError($exception->getMessage());
        }
    }

    public function create()
    {
        try {
            return view('admin.products.create', $this->service->getDefaultData());
        } catch (\Exception $exception) {
            return backPageError($exception->getMessage());
        }
    }

    public function store(StoreProductRequest $request)
    {
        try {
            return DB::transaction(function () use ($request) {
                $this->service->create($request->validated());
                return redirectPage('admin.products.index', trans('messages.success_created'));
            });
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }

    public function show(Product $product)
    {
        try {
            return view('admin.products.show', $this->service->getProduct($product));
        } catch (\Exception $exception) {
            return backPageError($exception->getMessage());
        }
    }

    public function edit(Product $product)
    {
        try {
            return view('admin.products.edit', $this->service->getProduct($product));
        } catch (\Exception $exception) {
            return backPageError($exception->getMessage());
        }
    }

    public function update(Product $product, UpdateProductRequest $request)
    {
        try {
            return DB::transaction(function () use ($product, $request) {
                $this->service->update($product, $request->validated());
                return backPage(trans('messages.success_updated'));
            });
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }

    public function destroy(Product $product)
    {
        try {
            return DB::transaction(function () use ($product) {
                $this->service->delete($product->load('titleTranslate', 'descriptionTranslate', 'instructionTranslate'));
                return redirectPage('admin.products.index', trans('messages.success_deleted'));
            });
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }

    public function updateIsActive(UpdateIsActiveRequest $request): JsonResponse
    {
        try {
            Product::query()
                ->find($request->input('data_id'))
                ->update([
                    'is_active' => $request->input('is_active') == 1 ? 1 : 0
                ]);
            return new JsonResponse(['status' => true]);
        } catch (\Exception $exception) {
            return new JsonResponse(['status' => false, 'message' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function getFilters(Request $request)
    {
        try {
            return view('admin.products._filter_options', $this->service->getFiltersData($request));
        } catch (\Exception $exception) {
            return backPageError($exception->getMessage());
        }
    }

    public function getSubCategories(Request $request)
    {
        try {
            return view('admin.products._sub_categories_options', $this->service->getSubCategories($request));
        } catch (\Exception $exception) {
            return backPageError($exception->getMessage());
        }
    }

    public function deleteImage(Product $product, Request $request)
    {
        try {
            $this->service->deleteImage($product, $request->all());
            notify()->success('', trans('messages.success_deleted'));
            return new JsonResponse(['status' => true]);
        } catch (\Exception $exception) {
            return new JsonResponse(['status' => false, 'message' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function deleteDocument(Product $product)
    {
        try {
            $this->service->deleteDocument($product);
            notify()->success('', trans('messages.success_deleted'));
            return new JsonResponse(['status' => true]);
        } catch (\Exception $exception) {
            return new JsonResponse(['status' => false, 'message' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
