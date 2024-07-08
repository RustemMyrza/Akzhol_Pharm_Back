<?php

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\ApiErrorException;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\BannerResource;
use App\Http\Resources\V1\HomeContentResource;
use App\Http\Resources\V1\SeoPageResource;
use App\Http\Resources\V1\BrandResource;
use App\Models\Banner;
use App\Models\Brand;
use App\Models\HomeContent;
use App\Models\SeoPage;
use Illuminate\Http\JsonResponse;
use stdClass;

class HomeController extends Controller
{
    /**
     * @throws ApiErrorException
     */
    public function __invoke()
    {
        try {
            $banners = Banner::query()->withTranslations()->isActive()->get();

            $brands = Brand::query()->with('titleTranslate')->get();

            $seoPage = SeoPage::query()->withMetaTranslations()->wherePage('home')->first();

            $homeContent = HomeContent::query()->with('titleTranslate', 'descriptionTranslate')->get();

            foreach ($homeContent as $key => $item)
            {
                switch($key)
                {
                    case 0:
                        $stocks = new HomeContentResource($item);
                        break;
                    case 1:
                        $novelties = new HomeContentResource($item);
                        break;
                    case 2:
                        $brandsTitle = new HomeContentResource($item);
                        break;
                }
            }

            $homeContentApi = new stdClass;
            $homeContentApi->stocks = $stocks;
            $homeContentApi->novelties = $novelties;
            $homeContentApi->brands = $brandsTitle;

            return new JsonResponse([
                'banners' => BannerResource::collection($banners),
                'homeContent' => $homeContentApi ? $homeContentApi : null,
                'brands' => BrandResource::collection($brands),
                'seoPage' => $seoPage ? new SeoPageResource($seoPage) : null
            ]);
        } catch (\Exception $exception) {
            return throw new ApiErrorException($exception->getMessage());
        }
    }
}
