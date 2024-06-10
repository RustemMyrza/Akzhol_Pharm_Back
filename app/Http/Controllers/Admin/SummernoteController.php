<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\Summernote\SummernoteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\Response;
use function Symfony\Component\Translation\t;

class SummernoteController extends Controller
{
    protected SummernoteService $summernoteService;

    public function __construct(SummernoteService $summernoteService)
    {
        $this->summernoteService = $summernoteService;
    }

    public function uploadImage(Request $request): JsonResponse
    {
        try {
            $url = $this->summernoteService->create($request->file('file'));

            return new JsonResponse([
                'status' => true,
                'url' => $url
            ]);
        } catch (\Exception $exception) {
            return new JsonResponse([
                'status' => false,
                'message' => trans('errors.error_server'),
                'errors' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function deleteImage(Request $request): JsonResponse
    {
        try {
            $this->summernoteService->delete($request->input('src'));

            return new JsonResponse([
                'status' => true,
                'message' => 'Успешно удалена'
            ]);
        } catch (\Exception $exception) {
            return new JsonResponse([
                'status' => false,
                'message' => trans('errors.error_server'),
                'errors' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
