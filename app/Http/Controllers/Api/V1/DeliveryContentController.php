<?php

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\ApiErrorException;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\DeliveryContentResource;
use App\Http\Resources\V1\SeoPageResource;
use App\Models\DeliveryContent;
use stdClass;
use App\Models\DeliveryFeature;
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
            $deliveryContent = DeliveryContent::query()->withTranslations()->get();
            foreach ($deliveryContent as $key => $item)
            {
                switch($key)
                {
                    case 0:
                        $delivery = new DeliveryContentResource($item);
                        break;
                    case 1:
                        $courier = new DeliveryContentResource($item);
                        break;
                    case 2:
                        $selfDelivery = new DeliveryContentResource($item);
                        break;
                }
            }

            $deliveryContentApi = new stdClass;
            $deliveryContentApi->delivery = $delivery;
            $deliveryContentApi->courier = $courier;
            $deliveryContentApi->selfDelivery = $selfDelivery;

            $seoPage = SeoPage::query()->withMetaTranslations()->wherePage('delivery')->first();

            return new JsonResponse([
                'deliveryContent' => $deliveryContentApi ? $deliveryContentApi : null,
                'seoPage' => $seoPage ? new SeoPageResource($seoPage) : null
            ]);
        }catch (\Exception $exception) {
            return throw new ApiErrorException($exception->getMessage());
        }
    }
}
