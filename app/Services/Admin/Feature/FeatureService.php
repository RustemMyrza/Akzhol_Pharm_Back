<?php

namespace App\Services\Admin\Feature;

use App\Enum\FeatureTypeEnum;
use App\Models\Feature;
use App\Services\Admin\Service;

class FeatureService extends Service
{
    public function getFeatures()
    {
        return [
            'features' => Feature::query()->withTranslations()->withCount('featureItems')->paginate()
        ];
    }

    public function create(array $data)
    {
        return Feature::query()
            ->create([
                'title' => $this->translateService->createTranslate($data['title']),
                'type' => $data['type'] ?? 0,
                'is_active' => $data['is_active'] ?? 0,
                'position' => $data['position'] ?? Feature::lastPosition(),
            ]);
    }

    public function update(Feature $feature, array $data)
    {
        $feature->title = $this->translateService->updateTranslate($feature->title, $data['title']);
        $feature->type = $data['type'] ?? 0;
        $feature->is_active = $data['is_active'] ?? 0;
        $feature->position = $data['position'] ?? Feature::lastPosition();
        return $feature->save();
    }

    public function delete(Feature $feature)
    {
        $feature->titleTranslate?->delete();
        if (count($feature->featureItems)) {
            foreach ($feature->featureItems as $featureItem) {
                $featureItem->delete();
            }
        }
        return $feature->delete();
    }

    public function getDefaultData(Feature $feature = null)
    {
        $data = [
            'lastPosition' => Feature::lastPosition(),
            'featureTypes' => FeatureTypeEnum::types()
        ];

        if ($feature !== null) {
            $data['feature'] = $feature->load('titleTranslate');
        }

        return $data;
    }
}
