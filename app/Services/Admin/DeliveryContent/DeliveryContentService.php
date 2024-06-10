<?php

namespace App\Services\Admin\DeliveryContent;

use App\Models\DeliveryContent;
use App\Models\DeliveryFeature;
use App\Models\DeliveryList;
use App\Services\Admin\Service;

class DeliveryContentService extends Service
{
    public function create(array $data)
    {
        return DeliveryContent::query()
            ->create([
                'description' => $this->translateService->createTranslate($data['description']),
                'content' => $this->translateService->createTranslate($data['content']),
            ]);
    }

    public function update(DeliveryContent $deliveryContent, array $data)
    {
        $deliveryContent->description = $this->translateService->updateTranslate($deliveryContent->description, $data['description']);
        if ($deliveryContent->content) {
            $deliveryContent->content = $this->translateService->updateTranslate($deliveryContent->content, $data['content']);
        } else {
            $deliveryContent->content = $this->translateService->createTranslate($data['content']);
        }
        return $deliveryContent->save();
    }

    public function getDeliveryData()
    {
        return [
            'deliveryContents' => DeliveryContent::query()->withTranslations()->get(),
            'deliveryFeatures' => DeliveryFeature::query()->withTranslations()->get(),
            'deliveryLists' => DeliveryList::query()->withTranslations()->get(),
        ];
    }
}
