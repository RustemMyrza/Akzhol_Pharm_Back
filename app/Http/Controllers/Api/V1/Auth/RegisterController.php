<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Exceptions\ApiErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\RegisterRequest;
use App\Http\Resources\V1\LoggedInResource;
use App\Services\Api\V1\AuthService;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @throws ApiErrorException
     */
    public function register(RegisterRequest $request)
    {
        try {
            $user = $this->authService->createUser($request->validated());
            return new LoggedInResource($this->authService->createToken($user));
        } catch (Exception $exception) {
            throw new ApiErrorException($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
