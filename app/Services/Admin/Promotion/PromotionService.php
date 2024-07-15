<?php

namespace App\Services\Admin\Promotion;

use App\Models\Promotion;
use App\Services\Admin\Service;

class PromotionService extends Service
{
    public function create(array $data)
    {
        return Promotion::query()
            ->create([
                'discount_amount' => $data['amount'] ? $data['amount'] : null,
                'content' => $this->translateService->createTranslate($data['description'])
            ]);
    }

    public function update(Promotion $Promotion, array $data)
    {
        $Promotion->description = $this->translateService->updateTranslate($Promotion->description, $data['description']);
        $Promotion->content = $this->translateService->updateTranslate($Promotion->content, $data['content']);
        if (isset($data['image'])) {
            $Promotion->image = $this->fileService->saveFile($data['image'], Promotion::IMAGE_PATH, $Promotion->image);
        }
        return $Promotion->save();
    }

    public function delete(Promotion $Promotion)
    {
        $Promotion->descriptionTranslate?->delete();
        $Promotion->contentTranslate?->delete();
        if ($Promotion->image) {
            $this->fileService->deleteFile($Promotion->image, Promotion::IMAGE_PATH);
        }
        return $Promotion->delete();
    }

    public function deleteImage(Promotion $Promotion)
    {
        if ($Promotion->image) {
            $this->fileService->deleteFile($Promotion->image, Promotion::IMAGE_PATH);
        }
        return $Promotion->update(['image' => null]);
    }

    public function getPromotion()
    {
        return [
            'Promotion' => Promotion::query()->withTranslations()->first()
        ];
    }

    public function getPromotions()
    {
        return [
            'Promotions' => Promotion::query()->withTranslations()->get()
        ];
    }
}