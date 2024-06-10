<?php

namespace App\Services\Admin\DeliveryFeature;

use App\Models\DeliveryFeature;
use App\Services\Admin\Service;

class DeliveryFeatureService extends Service
{
    public function create(array $data)
    {
        return DeliveryFeature::query()
            ->create([
                'title' => $this->translateService->createTranslate($data['title']),
                'is_active' => $data['is_active'] ?? 0,
                'position' => $data['position'] ?? DeliveryFeature::lastPosition(),
                'image' => isset($data['image']) ? $this->fileService->saveFile($data['image'], DeliveryFeature::IMAGE_PATH) : null,
            ]);
    }

    public function update(DeliveryFeature $deliveryFeature, array $data)
    {
        $deliveryFeature->title = $this->translateService->updateTranslate($deliveryFeature->title, $data['title']);
        $deliveryFeature->is_active = $data['is_active'] ?? 0;
        $deliveryFeature->position = $data['position'] ?? DeliveryFeature::lastPosition();

        if (isset($data['image'])) {
            $deliveryFeature->image = $this->fileService->saveFile($data['image'], DeliveryFeature::IMAGE_PATH, $deliveryFeature->image);
        }

        return $deliveryFeature->save();
    }

    public function delete(DeliveryFeature $deliveryFeature)
    {
        $deliveryFeature->titleTranslate?->delete();
        if ($deliveryFeature->image != null) {
            $this->fileService->deleteFile($deliveryFeature->image, DeliveryFeature::IMAGE_PATH);
        }
        return $deliveryFeature->save();
    }
}
