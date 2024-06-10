<?php

namespace App\Http\Controllers\Api\V1;

use App\Enum\PaymentStatusEnum;
use App\Exceptions\ApiErrorException;
use App\Http\Controllers\Controller;
use App\Services\Api\V1\OrderService;
use App\Services\Api\V1\PaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    private PaymentService $service;
    private OrderService $orderService;

    public function __construct(PaymentService $paymentService, OrderService $orderService)
    {
        $this->service = $paymentService;
        $this->orderService = $orderService;
    }


    /**
     * @throws ApiErrorException
     */
    public function paymentSuccess(Request $request)
    {
        try {
            $request->merge(['status' => PaymentStatusEnum::PAYED]);
            return DB::transaction(function () use ($request) {
                $payment = $this->service->update($request);

                if (!$payment) {
                    throw new ApiErrorException('Payment not found!');
                }

                $this->orderService->update($payment);

                return new JsonResponse(['message' => 'Payment success status saved!']);
            });
        } catch (\Exception $exception) {
            Log::channel('payment')->error('Exception payment success: ' . $exception->getMessage());
            return throw new ApiErrorException($exception->getMessage());
        }
    }

    /**
     * @throws ApiErrorException
     */
    public function paymentFailed(Request $request)
    {
        try {
            $request->merge(['status' => PaymentStatusEnum::FAILED]);
            return DB::transaction(function () use ($request) {
                $payment = $this->service->update($request);

                if (!$payment) {
                    throw new ApiErrorException('Payment not found!');
                }

                $this->orderService->update($payment);

                return new JsonResponse(['message' => 'Payment failed status saved!']);
            });
        } catch (\Exception $exception) {
            Log::channel('payment')->error('Exception payment failed: ' . $exception->getMessage());
            return throw new ApiErrorException($exception->getMessage());
        }
    }


}
