<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\UpdateCategorySeoRequest;
use App\Models\Category;
use App\Services\Admin\Category\CategoryService;
use Illuminate\Support\Facades\DB;

class CategorySeoController extends Controller
{
    public CategoryService $service;

    public function __construct(CategoryService $categoryService)
    {
        $this->service = $categoryService;
    }

    public function edit(Category $category)
    {
        $data['category'] = $category->load('metaTitleTranslate', 'metaDescriptionTranslate', 'metaKeywordTranslate');
        return view('admin.categories.editSeo', $data);
    }

    public function update(Category $category, UpdateCategorySeoRequest $request)
    {
        try {
            return DB::transaction(function () use ($category, $request) {
                 $this->service->updateSeo($category, $request->validated());
                return backPage(trans('messages.success_updated'));
            });
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }
}
