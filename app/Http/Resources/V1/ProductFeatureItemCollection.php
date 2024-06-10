<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductFeatureItemCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return $this->transformData($request);
    }

    protected function transformData($request): array
    {
        return $this->collection->groupBy(function ($featureItem) use ($request) {
            return $featureItem->feature->titleTranslate->{$request->language};
        })->map(function ($groupedItems, $featureTitle) use ($request) {
            return [
                $featureTitle => $groupedItems->pluck('titleTranslate.' . $request->language)->implode(', ')
            ];
        })->values()->all();
    }
}
