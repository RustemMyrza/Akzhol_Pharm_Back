<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FilterItem\StoreFilterItemRequest;
use App\Http\Requests\Admin\FilterItem\UpdateIsActiveRequest;
use App\Http\Requests\Admin\FilterItem\UpdateFilterItemRequest;
use App\Models\Filter;
use App\Models\FilterItem;
use App\Services\Admin\FilterItem\FilterItemService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class FilterItemController extends Controller
{
    public FilterItemService $service;

    public function __construct(FilterItemService $filterItemService)
    {
        $this->service = $filterItemService;
    }

    public function index(Filter $filter)
    {
        $data['filterItems'] = $this->service->getFilterItems($filter);
        $data['filter'] = $filter;
        return view('admin.filterItems.index', $data);
    }

    public function create(Filter $filter)
    {
        $data['lastPosition'] = FilterItem::lastPosition();
        $data['filter'] = $filter;
        return view('admin.filterItems.create', $data);
    }

    public function store(Filter $filter, StoreFilterItemRequest $request)
    {
        try {
            $this->service->create($filter, $request->validated());
            notify()->success('', trans('messages.success_created'));
            return redirect()->route('admin.filterItems.index', ['filter' => $filter]);
        } catch (\Exception $exception) {
            return back()->withErrors($exception->getMessage());
        }
    }

    public function edit(Filter $filter, FilterItem $filterItem)
    {
        $data['lastPosition'] = FilterItem::lastPosition();
        $data['filter'] = $filter;
        $data['filterItem'] = $filterItem;
        return view('admin.filterItems.edit', $data);
    }

    public function update(Filter $filter, FilterItem $filterItem, UpdateFilterItemRequest $request)
    {
        try {
            $this->service->update($filter, $filterItem, $request->validated());
            notify()->success('', trans('messages.success_updated'));
            return redirect()->route('admin.filterItems.index', ['filter' => $filter]);
        } catch (\Exception $exception) {
            return back()->withErrors($exception->getMessage());
        }
    }

    public function destroy(Filter $filter, FilterItem $filterItem)
    {
        try {
            $this->service->delete($filterItem);
            return backPage(trans('messages.success_deleted'));
        } catch (\Exception $exception) {
            return back()->withErrors($exception->getMessage());
        }
    }

    public function updateIsActive(UpdateIsActiveRequest $request, $filter): JsonResponse
    {
        try {
            FilterItem::query()
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
