<?php

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\ApiErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Application\StoreApplicationRequest;
use App\Services\Api\V1\ApplicationService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ApplicationController extends Controller
{
    private ApplicationService $service;

    public function __construct(ApplicationService $applicationService)
    {
        $this->service = $applicationService;
    }

    /**
     * @throws ApiErrorException
     */
    public function __invoke(StoreApplicationRequest $request): JsonResponse
    {
        try {
            $this->service->create($request->validated());

            return new JsonResponse([
                'message' => trans('message.success_verify_subscribe')
            ], Response::HTTP_CREATED);
        } catch (\Exception $exception) {
            return throw new ApiErrorException($exception->getMessage());
        }
    }
}
