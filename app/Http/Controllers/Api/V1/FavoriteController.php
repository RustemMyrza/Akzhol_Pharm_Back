<?php

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\ApiErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\User\CreateUserFavoriteRequest;
use App\Http\Resources\V1\CategoryProductResource;
use App\Library\ResourcePaginator;
use App\Services\Api\V1\UserFavoriteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    protected UserFavoriteService $service;

    public function __construct(UserFavoriteService $userFavoriteService)
    {
        $this->service = $userFavoriteService;
    }

    /**
     * @throws ApiErrorException
     */
    public function index(Request $request)
    {
        try {
            return new JsonResponse([
                'userFavorites' => new ResourcePaginator(CategoryProductResource::collection(
                    $this->service->getUserFavorites($request->user()->id)
                )),
            ]);
        } catch (\Exception $exception) {
            return throw new ApiErrorException($exception->getMessage());
        }
    }

    /**
     * @throws ApiErrorException
     */
    public function createOrDelete(CreateUserFavoriteRequest $request)
    {
        try {
            $userFavorite = $this->service->getUserFavorite($request->user()->id, $request->validated());

            if ($userFavorite){
                $this->service->delete($userFavorite);
                return new JsonResponse(['message' => trans('messages.success_deleted')]);
            }

            $this->service->create($request->user()->id, $request->validated());
            return new JsonResponse(['message' => trans('messages.success_created')]);
        } catch (\Exception $exception) {
            return throw new ApiErrorException($exception->getMessage());
        }
    }
}
