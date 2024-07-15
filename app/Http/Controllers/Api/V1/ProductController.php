<?php

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\ApiErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\ProductRequest;
use App\Http\Requests\Api\V1\SearchProductRequest;
use App\Http\Resources\V1\CategoryProductResource;
use App\Http\Resources\V1\ProductResource;
use App\Http\Resources\V1\SeoPageResource;
use App\Models\Product;
use App\Models\SeoPage;
use App\Models\Translate;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    /**
     * @throws ApiErrorException
     */
    public function index(ProductRequest $request)
    {
        try {
            $product = Product::query()
                ->withTranslations()
                ->with([
                    'category',
                    'productImages',
//                    'specificationTableTranslate',
                    'productFeatureItems.titleTranslate',
                    'productFeatureItems.feature.titleTranslate'
                ])
                ->where('slug', '=', "{$request->input('slug')}")
                ->firstOrFail();

            $seoPage = cache()->remember('apiSeoProduct-' . $product->id, SeoPage::CACHE_TIME, function () use ($product) {
                return Product::query()->withMetaTranslations()->first();
            });

            $similarProducts = cache()->remember('apiSimilarProducts-' . $product->category_id, Product::CACHE_TIME, function () use ($product) {
                return Product::query()
                    ->with('titleTranslate')
                    ->where('category_id', '=', $product->category_id)
                    ->limit(20)
                    ->get();
            });

            return new JsonResponse([
                'product' => $product ? new ProductResource($product) : null,
                'seoPage' => $seoPage ? new SeoPageResource($seoPage) : null,
                'similarProducts' => CategoryProductResource::collection($similarProducts)
            ]);
        } catch (ModelNotFoundException $modelNotFoundException) {
            throw new ApiErrorException(trans('messages.product_not_found'), Response::HTTP_NOT_FOUND);
        } catch (\Exception $exception) {
            throw new ApiErrorException($exception->getMessage());
        }
    }

    /**
     * @throws ApiErrorException
     */
    public function search(SearchProductRequest $request)
    {
        try {
            $products = Product::query()
                ->when($request->filled('text'), function ($query) use ($request) {
                    $keywords = explode(' ', $request->input('text'));

                    $query->where(function ($subQuery) use ($keywords) {
                        foreach ($keywords as $keyword) {

                            $subQuery->orWhereHas('titleTranslate', function ($titleQuery) use ($keyword) {
                                foreach (Translate::LANGUAGES as $language) {
                                    $titleQuery->where("$language", 'like', "%$keyword%");
                                }
                            });

                            $subQuery->orWhereHas('descriptionTranslate', function ($titleQuery) use ($keyword) {
                                foreach (Translate::LANGUAGES as $language) {
                                    $titleQuery->where("$language", 'like', "%$keyword%");
                                }
                            });

                            $subQuery->orWhereHas('instructionTranslate', function ($titleQuery) use ($keyword) {
                                foreach (Translate::LANGUAGES as $language) {
                                    $titleQuery->where("$language", 'like', "%$keyword%");
                                }
                            });

                        }
                    });
                })
                ->withTranslations()
                ->isActive()
                ->limit(35)
                ->get();

            return new JsonResponse([
                'products' => CategoryProductResource::collection($products)
            ]);
        } catch (\Exception $exception) {
            return throw new ApiErrorException($exception->getMessage());
        }
    }
}
