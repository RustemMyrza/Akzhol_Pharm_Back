<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\City\StoreCityRequest;
use App\Http\Requests\Admin\City\UpdateCityRequest;
use App\Http\Requests\Admin\City\UpdateIsActiveRequest;
use App\Models\City;
use App\Services\Admin\City\CityService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class CityController extends Controller
{
    public CityService $service;

    public function __construct(CityService $cityService)
    {
        $this->service = $cityService;
    }

    public function index()
    {
        $data['cities'] = $this->service->getCities();
        return view('admin.cities.index', $data);
    }

    public function create()
    {
        $data['lastPosition'] = City::lastPosition();
        return view('admin.cities.create', $data);
    }

    public function store(StoreCityRequest $request)
    {
        try {
            return DB::transaction(function () use ($request) {
                 $this->service->create($request->validated());
                return redirectPage('admin.cities.index', trans('messages.success_created'));
            });
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }

    public function edit(City $city)
    {
        $data['city'] = $city->load('titleTranslate');
        return view('admin.cities.edit', $data);
    }

    public function update(City $city, UpdateCityRequest $request)
    {
        try {
            return DB::transaction(function () use ($city, $request) {
                 $this->service->update($city, $request->validated());
                return redirectPage('admin.cities.index', trans('messages.success_updated'));
            });
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }

    public function destroy(City $city)
    {
        try {
            return DB::transaction(function () use ($city) {
                 $this->service->delete($city->load('titleTranslate'));
                return redirectPage('admin.cities.index', trans('messages.success_deleted'));
            });
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }

    public function updateIsActive(UpdateIsActiveRequest $request): JsonResponse
    {
        try {
            City::query()
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
