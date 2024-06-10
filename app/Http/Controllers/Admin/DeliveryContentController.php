<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DeliveryContent\StoreDeliveryContentRequest;
use App\Http\Requests\Admin\DeliveryContent\UpdateDeliveryContentRequest;
use App\Models\DeliveryContent;
use App\Services\Admin\DeliveryContent\DeliveryContentService;
use Illuminate\Support\Facades\DB;

class DeliveryContentController extends Controller
{
    public DeliveryContentService $service;

    public function __construct(DeliveryContentService $deliveryContentService)
    {
        $this->service = $deliveryContentService;
    }

    public function index()
    {
        try {
            return view('admin.deliveryContents.index', $this->service->getDeliveryData());
        } catch (\Exception $exception) {
            return backPageError($exception->getMessage());
        }
    }

    public function create()
    {
        try {
            return view('admin.deliveryContents.create');
        } catch (\Exception $exception) {
            return backPageError($exception->getMessage());
        }
    }

    public function store(StoreDeliveryContentRequest $request)
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

    public function edit(DeliveryContent $deliveryContent)
    {
        try {
            $data['deliveryContent'] = $deliveryContent->load('descriptionTranslate');
            return view('admin.deliveryContents.edit', $data);
        } catch (\Exception $exception) {
            return backPageError($exception->getMessage());
        }
    }

    public function update(DeliveryContent $deliveryContent, UpdateDeliveryContentRequest $request)
    {
        try {
            return DB::transaction(function () use ($deliveryContent, $request) {
                $this->service->update($deliveryContent, $request->validated());
                return backPage(trans('messages.success_updated'));
            });
        } catch (\Exception $exception) {
            return backPageError($exception->getMessage());
        }
    }
}
