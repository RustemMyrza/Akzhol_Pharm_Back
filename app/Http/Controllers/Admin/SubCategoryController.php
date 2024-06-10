<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SubCategory\StoreSubCategoryRequest;
use App\Http\Requests\Admin\SubCategory\UpdateSubCategoryRequest;
use App\Http\Requests\Admin\SubCategory\UpdateIsActiveRequest;
use App\Models\Category;
use App\Models\SubCategory;
use App\Services\Admin\SubCategory\SubCategoryService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class SubCategoryController extends Controller
{
    public SubCategoryService $service;

    public function __construct(SubCategoryService $subCategoryService)
    {
        $this->service = $subCategoryService;
    }

    public function index(Category $category)
    {
        return view('admin.subCategories.index', $this->service->getSubCategories($category));
    }

    public function create(Category $category)
    {
        return view('admin.subCategories.create', $this->service->getDefaultData($category));
    }

    public function store(Category $category, StoreSubCategoryRequest $request)
    {
        try {
            $this->service->create($category, $request->validated());
            notify()->success('', trans('messages.success_created'));
            return redirect()->route('admin.subCategories.index', $category);
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }

    public function edit(Category $category, SubCategory $subCategory)
    {
        $data = $this->service->getDefaultData($category);
        $data['subCategory'] = $subCategory;
        return view('admin.subCategories.edit', $data);
    }

    public function update(Category $category, SubCategory $subCategory, UpdateSubCategoryRequest $request)
    {
        try {
            $this->service->update($category, $subCategory, $request->validated());
            notify()->success('', trans('messages.success_updated'));
            return redirect()->route('admin.subCategories.index', $category);
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }

    public function destroy(Category $category, SubCategory $subCategory)
    {
        try {
            $this->service->delete($subCategory);
            return backPage(trans('messages.success_deleted'));
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }

    public function updateIsActive(UpdateIsActiveRequest $request): JsonResponse
    {
        try {
            SubCategory::query()
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
