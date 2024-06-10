<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\StoreCategoryRequest;
use App\Http\Requests\Admin\Category\UpdateCategoryRequest;
use App\Http\Requests\Admin\Category\UpdateIsActiveRequest;
use App\Http\Requests\Admin\Category\UpdateIsNewRequest;
use App\Models\Category;
use App\Services\Admin\Category\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    public CategoryService $service;

    public function __construct(CategoryService $categoryService)
    {
        $this->service = $categoryService;
    }

    public function index()
    {
        try {
            return view('admin.categories.index', $this->service->getCategories());
        } catch (\Exception $exception) {
            return backPageError($exception->getMessage());
        }
    }

    public function create()
    {
        try {
            return view('admin.categories.create', $this->service->getDefaultData());
        } catch (\Exception $exception) {
            return backPageError($exception->getMessage());
        }
    }

    public function store(StoreCategoryRequest $request)
    {
        try {
            return DB::transaction(function () use ($request) {
                $this->service->create($request->validated());
                return redirectPage('admin.categories.index', trans('messages.success_created'));
            });
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }

    public function edit(Category $category)
    {
        try {
            return view('admin.categories.edit', $this->service->getDefaultData($category));
        } catch (\Exception $exception) {
            return backPageError($exception->getMessage());
        }
    }

    public function update(Category $category, UpdateCategoryRequest $request)
    {
        try {
            return DB::transaction(function () use ($category, $request) {
                $this->service->update($category, $request->validated());
                return redirectPage('admin.categories.index', trans('messages.success_updated'));
            });
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }

    public function destroy(Category $category)
    {
        try {
            return DB::transaction(function () use ($category) {
                $this->service->delete($category->load('titleTranslate'));
                return redirectPage('admin.categories.index', trans('messages.success_deleted'));
            });
        } catch (\Exception $exception) {
            return backPageError($exception->getMessage());
        }
    }

    public function updateIsActive(UpdateIsActiveRequest $request): JsonResponse
    {
        try {
            Category::query()
                ->find($request->input('data_id'))
                ->update([
                    'is_active' => $request->input('is_active') == 1 ? 1 : 0
                ]);
            return new JsonResponse(['status' => true], Response::HTTP_OK);
        } catch (\Exception $exception) {
            return new JsonResponse(['status' => false, 'message' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function updateIsNew(UpdateIsNewRequest $request): JsonResponse
    {
        try {
            Category::query()
                ->find($request->input('data_id'))
                ->update([
                    'is_new' => $request->input('is_new') == 1 ? 1 : 0
                ]);
            return new JsonResponse(['status' => true], Response::HTTP_OK);
        } catch (\Exception $exception) {
            return new JsonResponse(['status' => false, 'message' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
