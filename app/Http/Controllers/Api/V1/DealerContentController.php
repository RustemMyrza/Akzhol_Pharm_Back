<?php

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\ApiErrorException;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\DealerContentResource;
use App\Http\Resources\V1\SeoPageResource;
use App\Models\DealerContent;
use App\Models\SeoPage;
use Illuminate\Http\JsonResponse;

class DealerContentController extends Controller
{
    /**
     * @throws ApiErrorException
     */
    public function __invoke(): JsonResponse
    {
        try {
            $dealerContent = cache()->remember('apiDealerContent', DealerContent::CACHE_TIME, function () {
                return DealerContent::query()->withTranslations()->first();
            });

            $seoPage = cache()->remember('apiSeoDealers', SeoPage::CACHE_TIME, function () {
                return SeoPage::query()->withMetaTranslations()->wherePage('dealers')->first();
            });

            return new JsonResponse([
                'dealerContent' => $dealerContent ? new DealerContentResource($dealerContent) : null,
                'seoPage' => $seoPage ? new SeoPageResource($seoPage) : null
            ]);
        } catch (\Exception $exception) {
            return throw new ApiErrorException($exception->getMessage());
        }
    }
}
