<?php

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\ApiErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\User\UpdateProfileRequest;
use App\Http\Resources\V1\User\UserProfileResource;
use App\Services\Api\V1\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected UserService $service;

    public function __construct(UserService $userService)
    {
        $this->service = $userService;
    }

    /**
     * @throws ApiErrorException
     */
    public function profile(Request $request)
    {
        try {
            return new UserProfileResource($request->user());
        } catch (\Exception $exception) {
            throw new ApiErrorException($exception->getMessage());
        }
    }

    /**
     * @throws ApiErrorException
     */
    public function updateProfile(UpdateProfileRequest $request)
    {
        try {
            $this->service->update($request->user(), $request->validated());

            return new JsonResponse([
                'user' => new UserProfileResource($request->user()),
                'message' => trans('messages.changes_saved')
            ]);
        } catch (\Exception $exception) {
            throw new ApiErrorException($exception->getMessage());
        }
    }
}
