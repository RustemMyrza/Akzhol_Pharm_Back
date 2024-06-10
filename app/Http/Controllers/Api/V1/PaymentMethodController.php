<?php

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\ApiErrorException;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\PaymentMethodResource;
use App\Http\Resources\V1\SeoPageResource;
use App\Models\PaymentMethod;
use App\Models\SeoPage;
use Illuminate\Http\JsonResponse;

class PaymentMethodController extends Controller
{
    /**
     * @throws ApiErrorException
     */
    public function __invoke(): JsonResponse
    {
        try {
            $payments = cache()->remember('apiPaymentMethods', PaymentMethod::CACHE_TIME, function () {
                return PaymentMethod::query()->withTranslations()->isActive()->get();
            });

            $seoPage = cache()->remember('apiSeoPayment', SeoPage::CACHE_TIME, function () {
                return SeoPage::query()->withMetaTranslations()->wherePage('payment')->first();
            });

            return new JsonResponse([
                'paymentMethods' => PaymentMethodResource::collection($payments),
                'seoPage' => $seoPage ? new SeoPageResource($seoPage) : null
            ]);
        } catch (\Exception $exception) {
            return throw new ApiErrorException($exception->getMessage());
        }
    }
}
