<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Filter\StoreFilterRequest;
use App\Http\Requests\Admin\Filter\UpdateFilterRequest;
use App\Http\Requests\Admin\Filter\UpdateIsActiveRequest;
use App\Models\Filter;
use App\Services\Admin\Filter\FilterService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class FilterController extends Controller
{
    public FilterService $service;

    public function __construct(FilterService $filterService)
    {
        $this->service = $filterService;
    }

    public function index()
    {
        $data['filters'] = $this->service->getFilters();
        return view('admin.filters.index', $data);
    }

    public function create()
    {
        $data['lastPosition'] = Filter::lastPosition();
        return view('admin.filters.create', $data);
    }

    public function store(StoreFilterRequest $request)
    {
        try {
            return DB::transaction(function () use ($request) {
                $this->service->create($request->validated());
                return redirectPage('admin.filters.index', trans('messages.success_created'));
            });
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }

    public function edit(Filter $filter)
    {
        $data['filter'] = $filter->load('titleTranslate');
        return view('admin.filters.edit', $data);
    }

    public function update(Filter $filter, UpdateFilterRequest $request)
    {
        try {
            return DB::transaction(function () use ($filter, $request) {
                $this->service->update($filter, $request->validated());
                return redirectPage('admin.filters.index', trans('messages.success_updated'));
            });
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }

    public function destroy(Filter $filter)
    {
        try {
            return DB::transaction(function () use ($filter) {
                $this->service->delete($filter->load('titleTranslate'));
                return redirectPage('admin.filters.index', trans('messages.success_deleted'));
            });
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }

    public function updateIsActive(UpdateIsActiveRequest $request): JsonResponse
    {
        try {
            Filter::query()
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
