<?php

namespace App\Services\Admin\Category;

use App\Models\Category;
use App\Models\Filter;
use App\Services\Admin\Service;

class CategoryService extends Service
{
    public function getCategories(): array
    {
        return [
            'categories' => Category::query()
                ->withCount('subCategories')
                ->withTranslations()
                ->get()
        ];
    }

    public function getDefaultData(Category $category = null): array
    {
        $data = [
            'lastPosition' => Category::lastPosition(),
            'filters' => cache()->remember('categoryFilters', Filter::CACHE_TIME, function () {
                return Filter::query()->withTranslations()->isActive()->get();
            })
        ];

        if ($category) {
            $data['category'] = $category->load('titleTranslate', 'pluralTitleTranslate', 'categoryFilters');
            $data['categoryFilters'] = $category->categoryFilters?->pluck('id')->toArray();
        }

        return $data;
    }

    public function create(array $data)
    {
        return Category::query()
            ->create([
                'title' => $this->translateService->createTranslate($data['title']),
                'plural_title' => $this->translateService->createTranslate($data['plural_title']),
                'is_active' => $data['is_active'] ?? 0,
                'is_new' => $data['is_new'] ?? 0,
                'is_important' => $data['is_important'] ?? 0,
                'position' => $data['position'] ?? Category::lastPosition(),
                'image' => isset($data['image']) ? $this->fileService->saveFile($data['image'], Category::IMAGE_PATH) : null,
            ]);
    }

    public function update(Category $category, array $data)
    {
        $category->title = $this->translateService->updateTranslate($category->title, $data['title']);

        if ($category->plural_title) {
            $category->plural_title = $this->translateService->updateTranslate($category->plural_title, $data['plural_title']);
        } else {
            $category->plural_title = $this->translateService->createTranslate($data['plural_title']);
        }

        if (isset($data['image'])) {
            $category->image = $this->fileService->saveFile($data['image'], Category::IMAGE_PATH, $category->image);
        }

        $category->is_active = $data['is_active'] ?? 0;
        $category->is_new = $data['is_new'] ?? 0;
        $category->is_important = $data['is_important'] ?? 0;
        $category->position = $data['position'] ?? Category::lastPosition();

        if (isset($data['filters'])) {
            $category->categoryFilters()->sync($data['filters']);
        } else {
            $category->categoryFilters()->sync([]);
        }

        return $category->save();
    }

    public function delete(Category $category)
    {
        $category->titleTranslate?->delete();
        $category->pluralTitleTranslate?->delete();
        $category->categoryFilters()?->sync([]);

        if ($category->image != null) {
            $this->fileService->deleteFile($category->image, Category::IMAGE_PATH);
        }

        return $category->delete();
    }

    public function updateSeo(Category $category, array $data)
    {
        if ($category->meta_title) {
            $this->translateService->updateTranslate($category->meta_title, $data['meta_title']);
        } else {
            $category->meta_title = $this->translateService->createTranslate($data['meta_title']);
        }

        if ($category->meta_description) {
            $this->translateService->updateTranslate($category->meta_description, $data['meta_description']);
        } else {
            $category->meta_description = $this->translateService->createTranslate($data['meta_description']);
        }

        if ($category->meta_keyword) {
            $this->translateService->updateTranslate($category->meta_keyword, $data['meta_keyword']);
        } else {
            $category->meta_keyword = $this->translateService->createTranslate($data['meta_keyword']);
        }

        return $category->save();
    }
}
