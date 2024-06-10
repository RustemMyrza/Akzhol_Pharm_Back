<?php

namespace App\Services\Admin\FilterItem;

use App\Models\Filter;
use App\Models\FilterItem;
use App\Services\Admin\Service;

class FilterItemService extends Service
{
    public function getFilterItems(Filter $filter)
    {
        return FilterItem::query()->whereFilterId($filter->id)->paginate(25);
    }

    public function create(Filter $filter, array $data)
    {
        return FilterItem::query()
            ->create([
                'title' => $this->translateService->createTranslate($data['title']),
                'filter_id' => $filter->id,
                'is_active' => $data['is_active'] ?? 0,
                'position' => $data['position'] ?? FilterItem::lastPosition(),
            ]);
    }

    public function update(Filter $filter, FilterItem $filterItem, array $data)
    {
        $filter->title = $this->translateService->updateTranslate($filterItem->title, $data['title']);
        $filterItem->filter_id = $filter->id;
        $filterItem->position = $data['position'] ?? FilterItem::lastPosition();
        $filterItem->is_active = $data['is_active'] ?? 0;
        return $filterItem->save();
    }

    public function delete(FilterItem $filterItem)
    {
        return $filterItem->delete();
    }
}
