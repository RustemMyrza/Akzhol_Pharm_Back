<?php

namespace App\Services\Admin\DeliveryContent;

use App\Models\DeliveryContent;
use App\Services\Admin\Service;
use Illuminate\Support\Facades\Log;

class DeliveryContentService extends Service
{
    public function create(array $data)
    {
        return DeliveryContent::query()
            ->create([
                'description' => $this->translateService->createTranslate($data['description']),
                'content' => $this->translateService->createTranslate($data['content']),
                'image' => isset($data['image']) ? $this->fileService->saveFile($data['image'], DeliveryContent::IMAGE_PATH) : null,
            ]);
    }

    public function update(DeliveryContent $deliveryContent, array $data)
    {
        $deliveryContent->description = $this->translateService->updateTranslate($deliveryContent->description, $data['description']);
        $deliveryContent->content = $this->translateService->updateTranslate($deliveryContent->content, $data['content']);
        if (isset($data['image'])) {
            Log::info('Image is set in the data array.');
            $deliveryContent->image = $this->fileService->saveFile($data['image'], DeliveryContent::IMAGE_PATH, $deliveryContent->image);
        } else {
            Log::info('Image is not set in the data array.');
        }
        return $deliveryContent->update();
    }

    public function delete(DeliveryContent $deliveryContent)
    {
        $deliveryContent->descriptionTranslate?->delete();
        $deliveryContent->contentTranslate?->delete();
        if ($deliveryContent->image) {
            $this->fileService->deleteFile($deliveryContent->image, DeliveryContent::IMAGE_PATH);
        }
        return $deliveryContent->delete();
    }

    public function deleteImage(DeliveryContent $deliveryContent)
    {
        if ($deliveryContent->image) {
            $this->fileService->deleteFile($deliveryContent->image, DeliveryContent::IMAGE_PATH);
        }
        return $deliveryContent->update(['image' => null]);
    }

    public function getDeliveryContent()
    {
        return [
            'deliveryContent' => DeliveryContent::query()->withTranslations()->first()
        ];
    }

    public function getDeliveryContents()
    {
        return [
            'deliveryContent' => DeliveryContent::query()->withTranslations()->get()
        ];
    }
}
