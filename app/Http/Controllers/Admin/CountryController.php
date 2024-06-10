<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Country\StoreCountryRequest;
use App\Http\Requests\Admin\Country\UpdateCountryRequest;
use App\Http\Requests\Admin\Country\UpdateIsActiveRequest;
use App\Models\Country;
use App\Services\Admin\Country\CountryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class CountryController extends Controller
{
    public CountryService $service;

    public function __construct(CountryService $countryService)
    {
        $this->service = $countryService;
    }

    public function index()
    {
        $data['countries'] = $this->service->getCountries();
        return view('admin.countries.index', $data);
    }

    public function create()
    {
        $data['lastPosition'] = Country::lastPosition();
        return view('admin.countries.create', $data);
    }

    public function store(StoreCountryRequest $request)
    {
        try {
            return DB::transaction(function () use ($request) {
                $this->service->create($request->validated());
                return redirectPage('admin.countries.index', trans('messages.success_created'));
            });
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }

    public function edit(Country $country)
    {
        $data['country'] = $country->load('titleTranslate');
        return view('admin.countries.edit', $data);
    }

    public function update(Country $country, UpdateCountryRequest $request)
    {
        try {
            return DB::transaction(function () use ($country, $request) {
                $this->service->update($country, $request->validated());
                return redirectPage('admin.countries.index', trans('messages.success_updated'));
            });
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }

    public function destroy(Country $country)
    {
        try {
            return DB::transaction(function () use ($country) {
                $this->service->delete($country->load('titleTranslate'));
                return redirectPage('admin.countries.index', trans('messages.success_deleted'));
            });
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }

    public function updateIsActive(UpdateIsActiveRequest $request): JsonResponse
    {
        try {
            Country::query()
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
