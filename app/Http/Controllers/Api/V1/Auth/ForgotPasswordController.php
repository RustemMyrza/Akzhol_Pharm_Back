<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Exceptions\ApiErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\ForgotPasswordRequest;
use App\Jobs\ForgotPasswordJob;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class ForgotPasswordController extends Controller
{
    /**
     * @throws ApiErrorException
     */
    public function forgotPassword(ForgotPasswordRequest $request)
    {
        try {
            $data = $request->validated();

            $user = User::query()
                ->where('email', '=', $data['email'])
                ->first();

            if (!$user) {
                throw new ApiErrorException(trans('messages.user_not_found'), Response::HTTP_NOT_FOUND);
            }

            $token = Str::random(64);

            DB::table('password_reset_tokens')
                ->insert([
                    'email' => $request['email'],
                    'token' => $token,
                    'created_at' => date('Y-m-d H:i:s')
                ]);

            ForgotPasswordJob::dispatch($user, $token);

            return new JsonResponse(['message' => 'Ссылка для сброса пароля успешно отправлено!']);
        } catch (\Exception $exception) {
            throw new ApiErrorException($exception->getMessage());
        }
    }
}
