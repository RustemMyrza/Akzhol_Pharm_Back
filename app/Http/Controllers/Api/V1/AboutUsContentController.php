<?php

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\ApiErrorException;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\AboutUsContentResource;
use App\Http\Resources\V1\SeoPageResource;
use App\Models\AboutUsContent;
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
            $aboutUsContent = cache()->remember('apiAboutUsContent', AboutUsContent::CACHE_TIME, function () {
                return AboutUsContent::query()->withTranslations()->first();
            });

            $seoPage = cache()->remember('apiSeoAbout', SeoPage::CACHE_TIME, function () {
                return SeoPage::query()->withMetaTranslations()->wherePage('about')->first();
            });

            return new JsonResponse([
                'aboutUsContent' => $aboutUsContent ? new AboutUsContentResource($aboutUsContent) : null,
                'seoPage' => $seoPage ? new SeoPageResource($seoPage) : null
            ]);
        } catch (\Exception $exception) {
            return throw new ApiErrorException($exception->getMessage());
        }
    }
}
