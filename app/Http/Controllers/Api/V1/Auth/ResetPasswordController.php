<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Exceptions\ApiErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\ResetPasswordRequest;
use App\Http\Resources\V1\LoggedInResource;
use App\Models\User;
use App\Services\Api\V1\AuthService;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use Symfony\Component\HttpFoundation\Response;

class ResetPasswordController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @throws ApiErrorException
     */
    public function resetPassword(ResetPasswordRequest $request)
    {
        try {
            $data = $request->validated();

            $resetPassword = DB::table('password_reset_tokens')
                ->where('email', '=', $data['email'])
                ->where('token', '=', $data['token'])
                ->exists();

            if (!$resetPassword) {
                throw new ApiErrorException('Данные для восстановления пароля не действительный', Response::HTTP_NOT_FOUND);
            }

            $user = User::query()->where('email', '=', $data['email'])->first();

            if (!$user) {
                throw new ApiErrorException(trans('messages.user_not_found'), Response::HTTP_NOT_FOUND);
            }

            $user->password = $data['password'];
            $user->save();

            DB::table('password_reset_tokens')
                ->where('email', '=', $data['email'])
                ->where('token', '=', $data['token'])
                ->delete();

            return new LoggedInResource($this->authService->createToken($user));
        } catch (Exception $exception) {
            throw new ApiErrorException($exception->getMessage());
        }
    }
}
