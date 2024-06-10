<?php

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\ApiErrorException;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\BannerResource;
use App\Http\Resources\V1\HomeContentResource;
use App\Http\Resources\V1\ImportantCategoryResource;
use App\Http\Resources\V1\NewCategoryResource;
use App\Http\Resources\V1\SeoPageResource;
use App\Http\Resources\V1\SliderResource;
use App\Models\Banner;
use App\Models\Category;
use App\Models\HomeContent;
use App\Models\SeoPage;
use App\Models\Slider;
use Illuminate\Http\JsonResponse;

class HomeController extends Controller
{
    /**
     * @throws ApiErrorException
     */
    public function __invoke()
    {
        try {
            $banners = cache()->remember('apiBanners', Banner::CACHE_TIME, function () {
                return Banner::query()->withTranslations()->isActive()->get();
            });

            $newCategories = cache()->remember('apiNewCategories', Category::CACHE_TIME, function () {
                return Category::query()->withTranslations()->with('products.titleTranslate')->isActive()->isNew()->get();
            });

            $sliders = cache()->remember('apiSliders', Slider::CACHE_TIME, function () {
                return Slider::query()->withTranslations()->isActive()->get();
            });

            $importantCategory = cache()->remember('apiImportantCategory', Category::CACHE_TIME, function () {
                return Category::query()->withTranslations()->with('products.titleTranslate')->isActive()->isImportant()->first();
            });

            $seoPage = cache()->remember('apiSeoHome', SeoPage::CACHE_TIME, function () {
                return SeoPage::query()->withMetaTranslations()->wherePage('home')->first();
            });

            $homeContent = cache()->remember('apiHomeContent', HomeContent::CACHE_TIME, function () {
                return HomeContent::query()->withTranslations()->first();
            });

            return new JsonResponse([
                'banners' => BannerResource::collection($banners),
                'newCategories' => NewCategoryResource::collection($newCategories),
                'sliders' => SliderResource::collection($sliders),
                'homeContent' => $homeContent ? new HomeContentResource($homeContent) : null,
                'importantCategory' => $importantCategory ? new ImportantCategoryResource($importantCategory) : null,
                'seoPage' => $seoPage ? new SeoPageResource($seoPage) : null
            ]);
        } catch (\Exception $exception) {
            return throw new ApiErrorException($exception->getMessage());
        }
    }
}
