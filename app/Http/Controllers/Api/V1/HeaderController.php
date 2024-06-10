<?php

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\ApiErrorException;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CategoryResource;
use App\Http\Resources\V1\CityResource;
use App\Http\Resources\V1\FeatureCollection;
use App\Http\Resources\V1\FilterResource;
use App\Http\Resources\V1\HeaderContactResource;
use App\Http\Resources\V1\MenuResource;
use App\Models\Category;
use App\Models\City;
use App\Models\Contact;
use App\Models\Feature;
use App\Models\Filter;
use App\Models\SeoPage;
use Illuminate\Http\JsonResponse;

class HeaderController extends Controller
{
    /**
     * @throws ApiErrorException
     */
    public function __invoke(): JsonResponse
    {
        try {
            $cities = cache()->remember('apiCities', City::CACHE_TIME, function () {
                return City::query()->withTranslations()->isActive()->get();
            });

            $menus = cache()->remember('apiMenus', SeoPage::CACHE_TIME, function () {
                return SeoPage::query()->withTranslations()->isActive()->get();
            });

            $categories = cache()->remember('apiCategories', Category::CACHE_TIME, function () {
                return Category::query()
                    ->with([
                        'categoryFilters.titleTranslate',
                        'categoryFilters.filterItems.titleTranslate',
                        'subCategories' => function ($query) {
                            $query->where('is_active', '=', 1)
                                ->with('titleTranslate');
                        }
                    ])
                    ->withTranslations()
                    ->isActive()
                    ->get();
            });

            $filters = cache()->remember('apiFilters', Filter::CACHE_TIME, function () {
                return Filter::query()
                    ->with(['filterItems' => function($query) {
                        $query->where('is_active', '=', 1)->with('titleTranslate');
                    }])
                    ->withTranslations()
                    ->isActive()
                    ->get();
            });

            $features = cache()->remember('apiFeatures', Feature::CACHE_TIME, function () {
                return Feature::query()
                    ->with(['featureItems' => function($query) {
                        $query->where('is_active', '=', 1)->with('titleTranslate');
                    }])
                    ->withTranslations()
                    ->isActive()
                    ->get();
            });

            $contact = cache()->remember('apiHeaderContact', Contact::CACHE_TIME, function () {
                return Contact::query()->withTranslations()->first();
            });

            return new JsonResponse([
                'cities' => CityResource::collection($cities),
                'menus' => MenuResource::collection($menus),
                'categories' => CategoryResource::collection($categories),
                'filters' => FilterResource::collection($filters),
                'features' => new FeatureCollection($features),
                'headerContact' => $contact ? new HeaderContactResource($contact) : null,
            ]);
        } catch (\Exception $exception) {
            return throw new ApiErrorException($exception->getMessage());
        }
    }
}
