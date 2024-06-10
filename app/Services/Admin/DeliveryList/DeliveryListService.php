<?php

namespace App\Services\Admin\DeliveryList;

use App\Models\DeliveryList;
use App\Services\Admin\Service;

class DeliveryListService extends Service
{
    public function create(array $data)
    {
        return DeliveryList::query()
            ->create([
                'description' => $this->translateService->createTranslate($data['description']),
                'is_active' => $data['is_active'] ?? 0,
                'position' => $data['position'] ?? DeliveryList::lastPosition(),
            ]);
    }

    public function update(DeliveryList $deliveryList, array $data)
    {
        $deliveryList->description = $this->translateService->updateTranslate($deliveryList->description, $data['description']);
        $deliveryList->is_active = $data['is_active'] ?? 0;
        $deliveryList->position = $data['position'] ?? DeliveryList::lastPosition();
        return $deliveryList->save();
    }

    public function delete(DeliveryList $deliveryList)
    {
        $deliveryList->descriptionTranslate?->delete();
        return $deliveryList->save();
    }
}
