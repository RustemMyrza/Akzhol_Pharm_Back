<?php

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\ApiErrorException;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\DeliveryContentResource;
use App\Http\Resources\V1\DeliveryFeatureResource;
use App\Http\Resources\V1\DeliveryListResource;
use App\Http\Resources\V1\SeoPageResource;
use App\Models\DeliveryContent;
use App\Models\DeliveryFeature;
use App\Models\DeliveryList;
use App\Models\SeoPage;
use Illuminate\Http\JsonResponse;

class DeliveryContentController extends Controller
{
    /**
     * @throws ApiErrorException
     */
    public function __invoke(): JsonResponse
    {
        try {
            $deliveryFeatures = cache()->remember('apiDeliveryFeatures', DeliveryFeature::CACHE_TIME, function () {
                return DeliveryFeature::query()->isActive()->withTranslations()->get();
            });

            $deliveryLists = cache()->remember('apiDeliveryLists', DeliveryList::CACHE_TIME, function () {
                return DeliveryList::query()->isActive()->withTranslations()->get();
            });

            $deliveryContent = cache()->remember('apiDeliveryContent', DeliveryContent::CACHE_TIME, function () {
                return DeliveryContent::query()->withTranslations()->first();
            });

            $seoPage = cache()->remember('apiSeoDelivery', SeoPage::CACHE_TIME, function () {
                return SeoPage::query()->withMetaTranslations()->wherePage('delivery')->first();
            });

            return new JsonResponse([
                'deliveryFeatures' => DeliveryFeatureResource::collection($deliveryFeatures),
                'deliveryLists' => DeliveryListResource::collection($deliveryLists),
                'deliveryContent' => $deliveryContent ? new DeliveryContentResource($deliveryContent) : null,
                'seoPage' => $seoPage ? new SeoPageResource($seoPage) : null
            ]);
        }catch (\Exception $exception) {
            return throw new ApiErrorException($exception->getMessage());
        }
    }
}
