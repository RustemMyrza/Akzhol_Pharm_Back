<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
//        $this->renderable(function (NotFoundHttpException $e, Request $request) {
//            if ($this->isApiRoute($request)) {
//                return new JsonResponse([
//                    'message' => trans('errors.not_found'),
//                ], Response::HTTP_NOT_FOUND);
//            }
//        });
//
//        $this->renderable(function (AuthenticationException $e, Request $request) {
//            if ($this->isApiRoute($request)) {
//                return new JsonResponse([
//                    'message' => trans('errors.unauthenticated'),
//                ], Response::HTTP_UNAUTHORIZED);
//            }
//        });
//
//        $this->renderable(function (BadMethodCallException $e, Request $request) {
//            if ($this->isApiRoute($request)) {
//                return new JsonResponse([
//                    'message' => trans('errors.error_server'),
//                ], Response::HTTP_UNAUTHORIZED);
//            }
//        });
//
//        $this->renderable(function (\Illuminate\Database\QueryException $e, Request $request) {
//            if ($this->isApiRoute($request)) {
//                return new JsonResponse([
//                    'message' => trans('errors.connection_not_db'),
//                ], Response::HTTP_UNAUTHORIZED);
//            }
//        });
//
//        $this->renderable(function (\Exception $exception, Request $request) {
//            if ($this->isApiRoute($request)) {
//                return new JsonResponse(['message' => $exception->getMessage()], $exception->getCode());
//            }
//        });
    }

    public function render($request, Throwable $e)
    {
        if (get_class($e) == 'Illuminate\Database\QueryException') {
            if ($this->isApiRoute($request)) {
                return new JsonResponse(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
            return response()->view('errors.500', [
                'title' => $e->getMessage(),
                'message' =>$e->getMessage(),
                'code' => 500
            ], 500);
        }

        if (!$this->isApiRoute($request)) {
            return parent::render($request, $e);
        }

        if (get_class($e) == 'Illuminate\Auth\AuthenticationException') {
            return new JsonResponse(['message' => trans('errors.unauthenticated')], Response::HTTP_UNAUTHORIZED);
        }

        return new JsonResponse([
            'message' => $e->getMessage(),
            'trace' => $e->getTrace()
        ], $this->getStatusCode($e->getCode()));
    }

    /**
     * @param $request
     * @return bool
     */
    private function isApiRoute($request): bool
    {
        return Str::startsWith($request->getRequestUri(), ['/api', 'api']);
    }

    protected function getStatusCode($code): int
    {
        return is_int($code) && $code >= 300 && $code < 600
            ? $code
            : Response::HTTP_INTERNAL_SERVER_ERROR;
    }
}
