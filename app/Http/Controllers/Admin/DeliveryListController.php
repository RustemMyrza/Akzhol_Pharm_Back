<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DeliveryList\StoreDeliveryListRequest;
use App\Http\Requests\Admin\DeliveryList\UpdateDeliveryListRequest;
use App\Http\Requests\Admin\DeliveryList\UpdateIsActiveRequest;
use App\Models\DeliveryList;
use App\Services\Admin\DeliveryList\DeliveryListService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class DeliveryListController extends Controller
{
    public DeliveryListService $service;

    public function __construct(DeliveryListService $deliveryListService)
    {
        $this->service = $deliveryListService;
    }

    public function create()
    {
        try {
            return view('admin.deliveryLists.create', ['lastPosition' => DeliveryList::lastPosition()]);
        } catch (\Exception $exception) {
            return backPageError($exception->getMessage());
        }
    }

    public function store(StoreDeliveryListRequest $request)
    {
        try {
            return DB::transaction(function () use ($request) {
                $this->service->create($request->validated());
                return redirectPage('admin.deliveryContents.index', trans('messages.success_created'));
            });
        } catch (\Exception $exception) {
            return backPageError($exception->getMessage());
        }
    }

    public function edit(DeliveryList $deliveryList)
    {
        try {
            return view('admin.deliveryLists.edit', ['deliveryList' => $deliveryList->load('descriptionTranslate')]);
        } catch (\Exception $exception) {
            return backPageError($exception->getMessage());
        }
    }

    public function update(DeliveryList $deliveryList, UpdateDeliveryListRequest $request)
    {
        try {
            return DB::transaction(function () use ($deliveryList, $request) {
                $this->service->update($deliveryList, $request->validated());
                return backPage(trans('messages.success_updated'));
            });
        } catch (\Exception $exception) {
            return backPageError($exception->getMessage());
        }
    }

    public function updateIsActive(UpdateIsActiveRequest $request): JsonResponse
    {
        try {
            DeliveryList::query()
                ->find($request->input('data_id'))
                ->update([
                    'is_active' => $request->input('is_active') == 1 ? 1 : 0
                ]);
            return new JsonResponse(['status' => true], Response::HTTP_OK);
        } catch (\Exception $exception) {
            return new JsonResponse(['status' => false, 'message' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
