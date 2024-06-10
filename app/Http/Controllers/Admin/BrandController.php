<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Brand\StoreBrandRequest;
use App\Http\Requests\Admin\Brand\UpdateBrandRequest;
use App\Http\Requests\Admin\Brand\UpdateIsActiveRequest;
use App\Models\Brand;
use App\Services\Admin\Brand\BrandService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class BrandController extends Controller
{
    public BrandService $service;

    public function __construct(BrandService $brandService)
    {
        $this->service = $brandService;
    }

    public function index()
    {
        $data['brands'] = $this->service->getBrands();
        return view('admin.brands.index', $data);
    }

    public function create()
    {
        $data['lastPosition'] = Brand::lastPosition();
        return view('admin.brands.create', $data);
    }

    public function store(StoreBrandRequest $request)
    {
        try {
            return DB::transaction(function () use ($request) {
                $this->service->create($request->validated());
                return redirectPage('admin.brands.index', trans('messages.success_created'));
            });
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }

    public function edit(Brand $brand)
    {
        $data['brand'] = $brand->load('titleTranslate');
        return view('admin.brands.edit', $data);
    }

    public function update(Brand $brand, UpdateBrandRequest $request)
    {
        try {
            return DB::transaction(function () use ($brand, $request) {
                $this->service->update($brand, $request->validated());
                return redirectPage('admin.brands.index', trans('messages.success_updated'));
            });
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }

    public function destroy(Brand $brand)
    {
        try {
            return DB::transaction(function () use ($brand) {
                $this->service->delete($brand->load('titleTranslate'));
                return redirectPage('admin.brands.index', trans('messages.success_deleted'));
            });
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }

    public function updateIsActive(UpdateIsActiveRequest $request): JsonResponse
    {
        try {
            Brand::query()
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
