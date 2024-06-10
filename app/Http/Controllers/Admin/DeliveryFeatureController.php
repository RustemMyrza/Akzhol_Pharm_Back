<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DeliveryFeature\StoreDeliveryFeatureRequest;
use App\Http\Requests\Admin\DeliveryFeature\UpdateDeliveryFeatureRequest;
use App\Http\Requests\Admin\DeliveryFeature\UpdateIsActiveRequest;
use App\Models\DeliveryFeature;
use App\Services\Admin\DeliveryFeature\DeliveryFeatureService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class DeliveryFeatureController extends Controller
{
    public DeliveryFeatureService $service;

    public function __construct(DeliveryFeatureService $deliveryFeatureService)
    {
        $this->service = $deliveryFeatureService;
    }

    public function create()
    {
        try {
            return view('admin.deliveryFeatures.create', ['lastPosition' => DeliveryFeature::lastPosition()]);
        } catch (\Exception $exception) {
            return backPageError($exception->getMessage());
        }
    }

    public function store(StoreDeliveryFeatureRequest $request)
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

    public function edit(DeliveryFeature $deliveryFeature)
    {
        try {
            return view('admin.deliveryFeatures.edit', ['deliveryFeature' => $deliveryFeature->load('titleTranslate')]);
        } catch (\Exception $exception) {
            return backPageError($exception->getMessage());
        }
    }

    public function update(DeliveryFeature $deliveryFeature, UpdateDeliveryFeatureRequest $request)
    {
        try {
            return DB::transaction(function () use ($deliveryFeature, $request) {
                $this->service->update($deliveryFeature, $request->validated());
                return backPage(trans('messages.success_updated'));
            });
        } catch (\Exception $exception) {
            return backPageError($exception->getMessage());
        }
    }

    public function updateIsActive(UpdateIsActiveRequest $request): JsonResponse
    {
        try {
            DeliveryFeature::query()
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
