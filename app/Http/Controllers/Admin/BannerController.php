<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Banner\DeleteBannerImageRequest;
use App\Http\Requests\Admin\Banner\StoreBannerRequest;
use App\Http\Requests\Admin\Banner\UpdateBannerRequest;
use App\Http\Requests\Admin\Banner\UpdateIsActiveRequest;
use App\Models\Banner;
use App\Services\Admin\BannerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class BannerController extends Controller
{
    public BannerService $service;

    public function __construct(BannerService $bannersService)
    {
        $this->service = $bannersService;
    }

    public function index()
    {
        try {
            return view('admin.banners.index', $this->service->getBanners());
        } catch (\Exception $exception) {
            return backPageError($exception->getMessage());
        }
    }

    public function create()
    {
        try {
            return view('admin.banners.create', $this->service->createData());
        } catch (\Exception $exception) {
            return backPageError($exception->getMessage());
        }
    }

    public function store(StoreBannerRequest $request)
    {
        try {
            return DB::transaction(function () use ($request) {
                $this->service->create($request->validated());
                return redirectPage('admin.banners.index', trans('messages.success_created'));
            });
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }

    public function edit(Banner $banner)
    {
        try {
            return view('admin.banners.edit', ['banner' => $banner->load('imageTranslate', 'mobileImageTranslate')]);
        } catch (\Exception $exception) {
            return backPageError($exception->getMessage());
        }
    }

    public function update(Banner $banner, UpdateBannerRequest $request)
    {
        try {
            return DB::transaction(function () use ($banner, $request) {
                $this->service->update($banner, $request->validated());
                return redirectPage('admin.banners.index', trans('messages.success_updated'));
            });
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }

    public function destroy(Banner $banner)
    {
        try {
            return DB::transaction(function () use ($banner) {
                $this->service->delete($banner->load('imageTranslate', 'mobileImageTranslate'));
                return redirectPage('admin.banners.index', trans('messages.success_deleted'));
            });
        } catch (\Exception $exception) {
            return back()->withErrors($exception->getMessage());
        }
    }

    public function deleteImage(Banner $banner, DeleteBannerImageRequest $request)
    {
        try {
            return DB::transaction(function () use ($banner, $request) {
                $this->service->deleteImage($banner, $request->validated());
                return backPage(trans('messages.success_deleted'));
            });
        } catch (\Exception $exception) {
            return back()->withErrors($exception->getMessage());
        }
    }

    public function updateIsActive(UpdateIsActiveRequest $request): JsonResponse
    {
        try {
            Banner::query()
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
