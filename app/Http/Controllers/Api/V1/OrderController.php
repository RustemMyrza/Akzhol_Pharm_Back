<?php

namespace App\Http\Controllers\Api\V1;

use App\Enum\OrderStatusEnum;
use App\Enum\PaymentMethodEnum;
use App\Enum\UserTypeEnum;
use App\Exceptions\ApiErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Order\StoreOrderRequest;
use App\Http\Resources\V1\OrderProductResource;
use App\Library\ResourcePaginator;
use App\Services\Api\V1\OrderService;
use App\Services\Api\V1\PaymentService;
use App\Services\EPayService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    private OrderService $service;
    private PaymentService $paymentService;
    private EPayService $ePayService;

    public function __construct(OrderService $orderService, PaymentService $paymentService, EPayService $ePayService)
    {
        $this->service = $orderService;
        $this->paymentService = $paymentService;
        $this->ePayService = $ePayService;
    }

    /**
     * @throws ApiErrorException
     */
    public function create(StoreOrderRequest $request): JsonResponse
    {
        try {
            return DB::transaction(function () use ($request) {
                $userId = $request->user()->id;
                $order = $this->service->create($request->validated(), $userId);

                $data = [
                    'order_id' => $order['order_id']
                ];

                if ($request->user_type == UserTypeEnum::INDIVIDUAL && $request->payment_method == PaymentMethodEnum::BANK_CARD) {
                    $payment = $this->paymentService->create($order);
                    $token = $this->ePayService->createToken($payment);

                    $data = array_merge($data, [
                        'token' => $token,
                        'amount' => $payment->amount,
                        'invoice_id' => $payment->invoice_id
                    ]);
                }

                return new JsonResponse([
                    'message' => trans('message.success_application'),
                    'data' => $data
                ], Response::HTTP_CREATED);
            });
        } catch (\Exception $exception) {
//            return throw new ApiErrorException(trans('errors.error_server'));
            return throw new ApiErrorException($exception->getMessage());
        }
    }

    /**
     * @throws ApiErrorException
     */
    public function current(Request $request)
    {
        try {
            return new JsonResponse([
                'orderProducts' => new ResourcePaginator(OrderProductResource::collection(
                    $this->service->getOrderProductsByStatus($request, [OrderStatusEnum::NEW]))
                )
            ]);
        } catch (\Exception $exception) {
            return throw new ApiErrorException(trans('errors.error_server'));
        }
    }

    /**
     * @throws ApiErrorException
     */
    public function deferred(Request $request)
    {
        try {
            return new JsonResponse([
                'orderProducts' => new ResourcePaginator(OrderProductResource::collection(
                    $this->service->getOrderProductsByStatus($request, [OrderStatusEnum::DEFERRED]))
                )
            ]);
        } catch (\Exception $exception) {
            return throw new ApiErrorException(trans('errors.error_server'));
        }
    }

    /**
     * @throws ApiErrorException
     */
    public function approved(Request $request)
    {
        try {
            return new JsonResponse([
                'orderProducts' => new ResourcePaginator(OrderProductResource::collection(
                    $this->service->getOrderProductsByStatus($request, [OrderStatusEnum::APPROVED]))
                )
            ]);
        } catch (\Exception $exception) {
            return throw new ApiErrorException(trans('errors.error_server'));
        }
    }

    /**
     * @throws ApiErrorException
     */
    public function declined(Request $request)
    {
        try {
            return new JsonResponse([
                'orderProducts' => new ResourcePaginator(OrderProductResource::collection(
                    $this->service->getOrderProductsByStatus($request, [OrderStatusEnum::DECLINED]))
                )
            ]);
        } catch (\Exception $exception) {
            return throw new ApiErrorException(trans('errors.error_server'));
        }
    }
}
