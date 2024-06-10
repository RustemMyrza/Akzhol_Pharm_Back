<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SeoPage\StoreSeoPageRequest;
use App\Http\Requests\Admin\SeoPage\UpdateIsActiveRequest;
use App\Http\Requests\Admin\SeoPage\UpdateSeoPageRequest;
use App\Models\SeoPage;
use App\Services\Admin\SeoPage\SeoPageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class SeoPageController extends Controller
{
    protected SeoPageService $service;

    public function __construct(SeoPageService $seoPageService)
    {
        $this->service = $seoPageService;
    }

    public function index()
    {
        return view('admin.seoPages.index', ['seoPages' => $this->service->getSeoPages()]);
    }

    public function create()
    {
        return view('admin.seoPages.create');
    }

    public function store(StoreSeoPageRequest $request)
    {
        try {
            return DB::transaction(function () use ($request) {
                 $this->service->create($request->validated());
                return redirectPage('admin.seoPages.index', trans('messages.success_created'));
            });
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }

    public function edit(SeoPage $seoPage)
    {
        return view('admin.seoPages.edit', ['seoPage' => $seoPage]);
    }

    public function update(SeoPage $seoPage, UpdateSeoPageRequest $request)
    {
        try {
            return DB::transaction(function () use ($seoPage, $request) {
                 $this->service->update($seoPage, $request->validated());
                return redirectPage('admin.seoPages.index', trans('messages.success_updated'));
            });
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }

    public function destroy(SeoPage $seoPage)
    {
        try {
            return DB::transaction(function () use ($seoPage) {
                 $this->service->delete($seoPage);
                return redirectPage('admin.seoPages.index', trans('messages.success_deleted'));
            });
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }

    public function updateIsActive(UpdateIsActiveRequest $request): JsonResponse
    {
        try {
            SeoPage::query()
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
