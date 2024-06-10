<?php

namespace App\Services\Admin\Filter;

use App\Models\Filter;
use App\Services\Admin\Service;

class FilterService extends Service
{
    public function getFilters()
    {
        return Filter::query()->withTranslations()->withCount('filterItems')->paginate();
    }

    public function create(array $data)
    {
        return Filter::query()
            ->create([
                'title' => $this->translateService->createTranslate($data['title']),
                'is_active' => $data['is_active'] ?? 0,
                'position' => $data['position'] ?? Filter::lastPosition(),
            ]);
    }

    public function update(Filter $filter, array $data)
    {
        $filter->title = $this->translateService->updateTranslate($filter->title, $data['title']);
        $filter->is_active = $data['is_active'] ?? 0;
        $filter->position = $data['position'] ?? Filter::lastPosition();
        return $filter->save();
    }

    public function delete(Filter $filter)
    {
        $filter->titleTranslate?->delete();
        if (count($filter->filterItems)) {
            foreach ($filter->filterItems as $filterItem) {
                $filterItem->delete();
            }
        }
        return $filter->delete();
    }

    public function getFiltersByCategoryId(int|string $categoryId)
    {
        return Filter::query()
            ->whereHas('filterCategories', function ($query) use ($categoryId) {
                $query->where('category_id', '=', $categoryId);
            })
            ->with(['filterItems.titleTranslate'])
            ->orderBy('position')
            ->orderBy('id')
            ->withTranslations()
            ->isActive()
            ->get();
    }
}
