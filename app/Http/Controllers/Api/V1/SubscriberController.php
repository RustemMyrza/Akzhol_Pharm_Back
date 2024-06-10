<?php

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\ApiErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Subscriber\SaveSubscriberRequest;
use App\Jobs\SubscriberConfirmJob;
use App\Services\Api\V1\SubscriberService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubscriberController extends Controller
{
    protected SubscriberService $service;

    public function __construct(
        SubscriberService $subscriberService
    )
    {
        $this->service = $subscriberService;
    }

    /**
     * @throws ApiErrorException
     */
    public function save(SaveSubscriberRequest $request): JsonResponse
    {
        try {
            $subscriber = $this->service->create(
                array_merge($request->validated(), ['user_id' => $request->user()->id])
            );

            if (!is_null($subscriber->token)) {
                SubscriberConfirmJob::dispatch($subscriber);

                return new JsonResponse([
                    'message' => trans('message.success_subscriber'),
                ], Response::HTTP_CREATED);
            }

            return new JsonResponse([
                'message' => trans('message.success_updated_subscriber'),
            ]);
        } catch (\Exception $exception) {
            throw new ApiErrorException($exception->getMessage());
        }
    }

    /**
     * @throws ApiErrorException
     */
    public function delete(Request $request): JsonResponse
    {
        try {
            $this->service->delete($request->user()->id);

            return new JsonResponse([
                'message' => trans('message.success_delete_subscriber'),
            ]);
        } catch (\Exception $exception) {
            throw new ApiErrorException($exception->getMessage());
        }
    }

    public function verify(string $token, string $email)
    {
        try {
            $subscriber = $this->service->find($token, $email);

            if (!$subscriber) {
                return redirect(url(config('client.subscribe_verify_error_url') . "?error_type=0"));
            }

            $this->service->update($subscriber);

            return redirect(url(config('client.subscribe_verify_success_url')));
        } catch (\Exception $exception) {
            $message = urlencode(base64_encode($exception->getMessage()));
            return redirect(url(config('client.subscribe_verify_error_url') . "?error_type=1&message=" . $message));
        }
    }
}
