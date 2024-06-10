<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\HomeContent\StoreHomeContentRequest;
use App\Http\Requests\Admin\HomeContent\UpdateHomeContentRequest;
use App\Models\HomeContent;
use App\Services\Admin\HomeContent\HomeContentService;
use Illuminate\Support\Facades\DB;

class HomeContentController extends Controller
{
    public HomeContentService $service;

    public function __construct(HomeContentService $homeContentService)
    {
        $this->service = $homeContentService;
    }

    public function index()
    {
        try {
            $data = $this->service->getHomeContent();
            if ($data['homeContent'])
                return redirect()->route('admin.homeContents.edit', $data);
            else
                return view('admin.homeContents.index', $this->service->getHomeContents());
        } catch (\Exception $exception) {
            return backPageError($exception->getMessage());
        }
    }

    public function create()
    {
        try {
            return view('admin.homeContents.create');
        } catch (\Exception $exception) {
            return backPageError($exception->getMessage());
        }
    }

    public function store(StoreHomeContentRequest $request)
    {
        try {
            return DB::transaction(function () use ($request) {
                $this->service->create($request->validated());
                return redirectPage('admin.homeContents.index', trans('messages.success_created'));
            });
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }

    public function edit(HomeContent $homeContent)
    {
        try {
            $data['homeContent'] = $homeContent->load('descriptionTranslate');
            return view('admin.homeContents.edit', $data);
        } catch (\Exception $exception) {
            return backPageError($exception->getMessage());
        }
    }

    public function update(HomeContent $homeContent, UpdateHomeContentRequest $request)
    {
        try {
            return DB::transaction(function () use ($homeContent, $request) {
                $this->service->update($homeContent, $request->validated());
                return backPage(trans('messages.success_updated'));
            });
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }
}
