<?php

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\ApiErrorException;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\AboutUsContentResource;
use App\Models\AboutUsContent;
use stdClass;
use App\Http\Resources\V1\SeoPageResource;
use App\Models\SeoPage;
use Illuminate\Http\JsonResponse;

class AboutUsContentController extends Controller
{
    /**
     * @throws ApiErrorException
     */
    public function __invoke(): JsonResponse
    {
        try {
            $aboutUsContent = AboutUsContent::query()->with('descriptionTranslate', 'contentTranslate')->get();

            foreach ($aboutUsContent as $key => $item)
            {
                switch($key)
                {
                    case 0:
                        $aboutBlock = new AboutUsContentResource($item);
                        break;
                    case 1:
                        $paying = new AboutUsContentResource($item);
                        break;
                    case 2:
                        $distributor = new AboutUsContentResource($item);
                        break;
                    case 3:
                        $points[] = new AboutUsContentResource($item);
                        break;
                    case 4:
                        $points[] = new AboutUsContentResource($item);
                        break;
                    case 5:
                        $points[] = new AboutUsContentResource($item);
                        break;
                    case 6:
                        $points[] = new AboutUsContentResource($item);
                        break;
                    case 7:
                        $points[] = new AboutUsContentResource($item);
                        break;
                    case 8:
                        $points[] = new AboutUsContentResource($item);
                        break;
                }
            }

            $aboutUsContentApi = new stdClass;
            $aboutUsContentApi->aboutCompany = $aboutBlock;
            $aboutUsContentApi->paying = $paying;
            $aboutUsContentApi->distributor = $distributor;
            $aboutUsContentApi->points = $points;

            $seoPage = SeoPage::query()->withMetaTranslations()->wherePage('about')->first();

            return new JsonResponse([
                'aboutUsContent' => $aboutUsContentApi ? $aboutUsContentApi : null,
                'seoPage' => $seoPage ? new SeoPageResource($seoPage) : null
            ]);
        } catch (\Exception $exception) {
            return throw new ApiErrorException($exception->getMessage());
        }
    }
}
