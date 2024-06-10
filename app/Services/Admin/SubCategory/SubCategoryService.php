<?php

namespace App\Services\Admin\SubCategory;

use App\Models\Category;
use App\Models\SubCategory;
use App\Services\Admin\Service;

class SubCategoryService extends Service
{
    public function getSubCategories(Category $category): array
    {
        return [
            'category' => $category,
            'subCategories' => SubCategory::query()
                ->where('category_id', '=', $category->id)
                ->withTranslations()
                ->paginate()
        ];
    }

    public function getDefaultData(Category $category): array
    {
        return [
            'category' => $category,
            'lastPosition' => SubCategory::lastPosition(),
        ];
    }

    public function create(Category $category, array $data)
    {
        return SubCategory::query()
            ->create([
                'title' => $this->translateService->createTranslate($data['title']),
                'category_id' => $category->id,
                'is_active' => $data['is_active'] ?? 0,
                'position' => $data['position'] ?? SubCategory::lastPosition(),
            ]);
    }

    public function update(Category $category, SubCategory $subCategory,array $data)
    {
        $subCategory->title = $this->translateService->updateTranslate($subCategory->title, $data['title']);

        $subCategory->category_id = $category->id;
        $subCategory->is_active = $data['is_active'] ?? 0;
        $subCategory->position = $data['position'] ?? SubCategory::lastPosition();
        return $subCategory->save();
    }

    public function delete(SubCategory $subCategory)
    {
        $subCategory->titleTranslate?->delete();
        return $subCategory->delete();
    }

    public function getSubCategoriesByCategoryId(int $categoryId)
    {
        return SubCategory::query()
            ->where('category_id', '=', $categoryId)
            ->orderBy('position')
            ->orderBy('id')
            ->isActive()
            ->get();
    }
}
