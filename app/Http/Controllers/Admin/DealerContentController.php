<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DealerContent\StoreDealerContentRequest;
use App\Http\Requests\Admin\DealerContent\UpdateDealerContentRequest;
use App\Models\DealerContent;
use App\Services\Admin\DealerContent\DealerContentService;
use Illuminate\Support\Facades\DB;

class DealerContentController extends Controller
{
    public DealerContentService $service;

    public function __construct(DealerContentService $dealerContentService)
    {
        $this->service = $dealerContentService;
    }

    public function index()
    {
        try {
            $data = $this->service->getDealerContent();
            if ($data['dealerContent'])
                return redirect()->route('admin.dealerContents.edit', $data);
            else
                return view('admin.dealerContents.index', $this->service->getDealerContents());
        } catch (\Exception $exception) {
            return backPageError($exception->getMessage());
        }
    }

    public function create()
    {
        try {
            return view('admin.dealerContents.create');
        } catch (\Exception $exception) {
            return backPageError($exception->getMessage());
        }
    }

    public function store(StoreDealerContentRequest $request)
    {
        try {
            return DB::transaction(function () use ($request) {
                $this->service->create($request->validated());
                return redirectPage('admin.dealerContents.index', trans('messages.success_created'));
            });
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }

    public function edit(DealerContent $dealerContent)
    {
        try {
            $data['dealerContent'] = $dealerContent->load('descriptionTranslate');
            return view('admin.dealerContents.edit', $data);
        } catch (\Exception $exception) {
            return backPageError($exception->getMessage());
        }
    }

    public function update(DealerContent $dealerContent, UpdateDealerContentRequest $request)
    {
        try {
            return DB::transaction(function () use ($dealerContent, $request) {
                $this->service->update($dealerContent, $request->validated());
                return backPage(trans('messages.success_updated'));
            });
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }

}
