<?php

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\ApiErrorException;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\PaymentContentResource;
use App\Http\Resources\V1\SeoPageResource;
use App\Models\PaymentContent;
use stdClass;
use App\Models\SeoPage;
use Illuminate\Http\JsonResponse;

class PaymentContentController extends Controller
{
    /**
     * @throws ApiErrorException
     */
    public function __invoke(): JsonResponse
    {
        try {
            $paymentContent = PaymentContent::query()->withTranslations()->get();

            foreach ($paymentContent as $key => $item)
            {
                switch($key)
                {
                    case 0:
                        $description = new PaymentContentResource($item);
                        break;
                    case 1:
                        $steps[] = new PaymentContentResource($item);
                        break;
                    case 2:
                        $steps[] = new PaymentContentResource($item);
                        break;
                    case 3:
                        $steps[] = new PaymentContentResource($item);
                        break;
                    case 4:
                        $steps[] = new PaymentContentResource($item);
                        break;
                }
            }

            $paymentContentApi = new stdClass;
            $paymentContentApi->description = $description;
            $paymentContentApi->steps = $steps;

            $seoPage = SeoPage::query()->withMetaTranslations()->wherePage('delivery')->first();

            return new JsonResponse([
                'paymentContent' => $paymentContentApi ? $paymentContentApi : null,
                'seoPage' => $seoPage ? new SeoPageResource($seoPage) : null
            ]);
        }catch (\Exception $exception) {
            return throw new ApiErrorException($exception->getMessage());
        }
    }
}
