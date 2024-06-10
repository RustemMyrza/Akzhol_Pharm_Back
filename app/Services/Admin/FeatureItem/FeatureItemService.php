<?php

namespace App\Services\Admin\FeatureItem;

use App\Models\Feature;
use App\Models\FeatureItem;
use App\Services\Admin\Service;

class FeatureItemService extends Service
{
    public function getFeatureItems(Feature $feature): array
    {
        return [
            'feature' => $feature,
            'featureItems' => FeatureItem::query()
                ->where('feature_id', '=', $feature->id)
                ->paginate(25),
        ];
    }

    public function create(Feature $feature, array $data)
    {
        return FeatureItem::query()
            ->create([
                'title' => $this->translateService->createTranslate($data['title']),
                'feature_id' => $feature->id,
                'is_active' => $data['is_active'] ?? 0,
                'position' => $data['position'] ?? FeatureItem::lastPosition(),
            ]);
    }

    public function update(Feature $feature, FeatureItem $featureItem, array $data)
    {
        $featureItem->title = $this->translateService->updateTranslate($featureItem->title, $data['title']);
        $featureItem->feature_id = $feature->id;
        $featureItem->position = $data['position'] ?? FeatureItem::lastPosition();
        $featureItem->is_active = $data['is_active'] ?? 0;
        return $featureItem->save();
    }

    public function delete(FeatureItem $featureItem)
    {
        $featureItem->titleTranslate?->delete();
        return $featureItem->delete();
    }

    public function getDefaultData(Feature $feature, FeatureItem $featureItem = null): array
    {
        $data = [
            'lastPosition' => FeatureItem::lastPosition(),
            'feature' => $feature
        ];

        if ($featureItem !== null) {
            $data['featureItem'] = $featureItem->load('titleTranslate');
        }

        return $data;
    }
}
