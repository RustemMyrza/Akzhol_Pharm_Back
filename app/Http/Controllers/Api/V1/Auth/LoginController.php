<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Exceptions\ApiErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\LoginRequest;
use App\Http\Resources\V1\LoggedInResource;
use App\Models\Client;
use App\Services\Api\V1\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @throws ApiErrorException
     */
    public function login(LoginRequest $request)
    {
        $user = Client::query()->whereEmail($request->input('email'))->first();

        if (!$user) {
            throw new ApiErrorException(trans('messages.user_not_found'));
        }

        if (!Hash::check($request->input('password'), $user->password)) {
            throw new ApiErrorException(trans('messages.email_password_error'));
        }

        return new LoggedInResource($this->authService->createToken($user));
    }

    /**
     * @throws ApiErrorException
     */
    public function logout(Request $request)
    {
        try {
            $request->user()->tokens()->delete();
            return new JsonResponse(['message' => trans('messages.successfully_logged_out')]);
        } catch (\Exception $exception) {
            return throw new ApiErrorException($exception->getMessage());
        }
    }
}
