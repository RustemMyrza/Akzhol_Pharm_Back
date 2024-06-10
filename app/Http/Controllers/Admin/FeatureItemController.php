<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FeatureItem\StoreFeatureItemRequest;
use App\Http\Requests\Admin\FeatureItem\UpdateIsActiveRequest;
use App\Http\Requests\Admin\FeatureItem\UpdateFeatureItemRequest;
use App\Models\Feature;
use App\Models\FeatureItem;
use App\Services\Admin\FeatureItem\FeatureItemService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class FeatureItemController extends Controller
{
    public FeatureItemService $service;

    public function __construct(FeatureItemService $featureItemService)
    {
        $this->service = $featureItemService;
    }

    public function index(Feature $feature)
    {
        try {
            return view('admin.featureItems.index', $this->service->getFeatureItems($feature));
        } catch (\Exception $exception) {
            return backPageError($exception->getMessage());
        }
    }

    public function create(Feature $feature)
    {
        try {
            return view('admin.featureItems.create', $this->service->getDefaultData($feature));
        } catch (\Exception $exception) {
            return backPageError($exception->getMessage());
        }
    }

    public function store(Feature $feature, StoreFeatureItemRequest $request)
    {
        try {
            $this->service->create($feature, $request->validated());

            notify()->success('', trans('messages.success_created'));
            return redirect()->route('admin.featureItems.index', ['feature' => $feature]);
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }

    public function edit(Feature $feature, FeatureItem $featureItem)
    {
        try {
            return view('admin.featureItems.edit', $this->service->getDefaultData($feature, $featureItem));
        } catch (\Exception $exception) {
            return backPageError($exception->getMessage());
        }
    }

    public function update(Feature $feature, FeatureItem $featureItem, UpdateFeatureItemRequest $request)
    {
        try {
            $this->service->update($feature, $featureItem, $request->validated());

            notify()->success('', trans('messages.success_updated'));
            return redirect()->route('admin.featureItems.index', ['feature' => $feature]);
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }

    public function destroy(Feature $feature, FeatureItem $featureItem)
    {
        try {
            $this->service->delete($featureItem);

            return backPage(trans('messages.success_deleted'));
        } catch (\Exception $exception) {
            return back()->withErrors($exception->getMessage());
        }
    }

    public function updateIsActive(UpdateIsActiveRequest $request, $feature): JsonResponse
    {
        try {
            FeatureItem::query()
                ->find($request->input('data_id'))
                ->update([
                    'is_active' => $request->input('is_active') == 1 ? 1 : 0
                ]);
            return new JsonResponse(['status' => true]);
        } catch (\Exception $exception) {
            return new JsonResponse(['status' => false, 'message' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
