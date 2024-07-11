<?php

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\ApiErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\CategoryRequest;
use App\Http\Resources\V1\CategoryResource;
use App\Http\Resources\V1\CategoryProductResource;
use App\Http\Resources\V1\SeoPageResource;
use App\Library\ResourcePaginator;
use App\Models\Category;
use App\Models\FeatureItem;
use App\Models\Product;
use App\Models\SeoPage;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    /**
     * @throws ApiErrorException
     */
    public function __invoke(CategoryRequest $request): JsonResponse
    {
        try {
            $newCategories = cache()->remember('apiNewCatalogCategories', Category::CACHE_TIME, function () {
                return Category::query()
                    ->with(['categoryFilters.titleTranslate', 'categoryFilters.filterItems.titleTranslate'])
                    ->withTranslations()
                    ->isActive()
                    ->isNew()
                    ->get();
            });

            $featureItemIds = $this->getProductFeatureItemIds($request->feature_item_ranges ?? [], $request->language);

            $products = Product::query()
                ->when($request->filled('category_id'), function ($query) use ($request) {
                    return $query->where('category_id', '=', $request->category_id);
                })
                ->when($request->filled('sub_category_id'), function ($query) use ($request) {
                    return $query->where('sub_category_id', '=', $request->sub_category_id);
                })
                ->when($request->filled('filter_item_ids'), function ($query) use ($request) {
                    $filterItemIds = array_map('intval', array_values(explode(",", $request->filter_item_ids)));

                    $query->whereHas('productFilterItems', function ($query) use ($filterItemIds) {
                        return $query->whereIn('id', $filterItemIds);
                    });
                })
                ->when($request->filled('feature_item_ids'), function ($query) use ($request) {
                    $featureItemIds = array_map('intval', array_values(explode(",", $request->feature_item_ids)));

                    $query->whereHas('productFeatureItems', function ($query) use ($featureItemIds) {
                        return $query->whereIn('id', $featureItemIds);
                    });
                })
                ->when(!$featureItemIds['is_empty'], function ($query) use ($featureItemIds) {
                    $query->whereHas('productFeatureItems', function ($query) use ($featureItemIds) {
                        $query->whereIn('product_feature_items.feature_item_id', $featureItemIds['results']);
                    });
                })
                ->isActive()
                ->orderBy('position')
                ->orderBy('id')
                ->with(['titleTranslate'])
                ->paginate(20);

            $seoPage = cache()->remember('apiSeoCatalog', SeoPage::CACHE_TIME, function () {
                return SeoPage::query()->withMetaTranslations()->wherePage('catalog')->first();
            });
            
            return new JsonResponse([
                'categories' => CategoryResource::collection($newCategories),
                'products' => new ResourcePaginator(CategoryProductResource::collection($products)),
                'seoPage' => $seoPage ? new SeoPageResource($seoPage) : null
            ]);
        } catch (\Exception $exception) {
            return throw new ApiErrorException($exception->getMessage());
        }
    }

    private function getProductFeatureItemIds(array $featureItemRanges, string $language): array
    {
        if (empty($featureItemRanges)) {
            return [
                'is_empty' => true
            ];
        }
        $resultIds = [];

        foreach ($featureItemRanges as $featureItemRange) {
            $min = $featureItemRange['min'];
            $max = $featureItemRange['max'];

            if ($min > $max) {
                [$min, $max] = [$max, $min];
            }

            $featureItemValues = [];

            $featureItems = FeatureItem::query()
                ->where('feature_id', '=', $featureItemRange['id'])
                ->with('titleTranslate')
                ->get();

            foreach ($featureItems as $featureItem) {
                $featureItemValues[$featureItem->id] = (int)$featureItem->titleTranslate->{$language};
            }

            foreach ($featureItemValues as $key => $value) {
                if ($value >= $min && $value <= $max) {
                    $resultIds[] = $key;
                }
            }
        }

        return [
            'is_empty' => false,
            'results' => $resultIds
        ];
    }
}
