<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Feature\StoreFeatureRequest;
use App\Http\Requests\Admin\Feature\UpdateFeatureRequest;
use App\Http\Requests\Admin\Feature\UpdateIsActiveRequest;
use App\Models\Feature;
use App\Services\Admin\Feature\FeatureService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class FeatureController extends Controller
{
    public FeatureService $service;

    public function __construct(FeatureService $featureService)
    {
        $this->service = $featureService;
    }

    public function index()
    {
        try {
            return view('admin.features.index', $this->service->getFeatures());
        } catch (\Exception $exception) {
            return backPageError($exception->getMessage());
        }
    }

    public function create()
    {
        try {
            return view('admin.features.create', $this->service->getDefaultData());
        } catch (\Exception $exception) {
            return backPageError($exception->getMessage());
        }
    }

    public function store(StoreFeatureRequest $request)
    {
        try {
            return DB::transaction(function () use ($request) {
                $this->service->create($request->validated());
                return redirectPage('admin.features.index', trans('messages.success_created'));
            });
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }

    public function edit(Feature $feature)
    {
        try {
            return view('admin.features.edit', $this->service->getDefaultData($feature));
        } catch (\Exception $exception) {
            return backPageError($exception->getMessage());
        }
    }

    public function update(Feature $feature, UpdateFeatureRequest $request)
    {
        try {
            return DB::transaction(function () use ($feature, $request) {
                $this->service->update($feature, $request->validated());
                return redirectPage('admin.features.index', trans('messages.success_updated'));
            });
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }

    public function destroy(Feature $feature)
    {
        try {
            return DB::transaction(function () use ($feature) {
                $this->service->delete($feature->load('titleTranslate'));
                return redirectPage('admin.features.index', trans('messages.success_deleted'));
            });
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }

    public function updateIsActive(UpdateIsActiveRequest $request): JsonResponse
    {
        try {
            Feature::query()
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
