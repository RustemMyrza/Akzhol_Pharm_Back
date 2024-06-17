<?php

namespace App\Services\Admin\PaymentContent;

use App\Models\PaymentContent;
use App\Services\Admin\Service;

class PaymentContentService extends Service
{
    public function create(array $data)
    {
        return PaymentContent::query()
            ->create([
                'description' => $this->translateService->createTranslate($data['description']),
                'content' => $this->translateService->createTranslate($data['content']),
                'image' => isset($data['image']) ? $this->fileService->saveFile($data['image'], PaymentContent::IMAGE_PATH) : null,
            ]);
    }

    public function update(PaymentContent $paymentContent, array $data)
    {
        $paymentContent->description = $this->translateService->updateTranslate($paymentContent->description, $data['description']);
        $paymentContent->content = $this->translateService->updateTranslate($paymentContent->content, $data['content']);
        if (isset($data['image'])) {
            $paymentContent->image = $this->fileService->saveFile($data['image'], PaymentContent::IMAGE_PATH, $paymentContent->image);
        }
        return $paymentContent->save();
    }

    public function delete(PaymentContent $paymentContent)
    {
        $paymentContent->descriptionTranslate?->delete();
        $paymentContent->contentTranslate?->delete();
        if ($paymentContent->image) {
            $this->fileService->deleteFile($paymentContent->image, PaymentContent::IMAGE_PATH);
        }
        return $paymentContent->delete();
    }

    public function deleteImage(PaymentContent $paymentContent)
    {
        if ($paymentContent->image) {
            $this->fileService->deleteFile($paymentContent->image, PaymentContent::IMAGE_PATH);
        }
        return $paymentContent->update(['image' => null]);
    }

    public function getPaymentContent()
    {
        return [
            'paymentContent' => PaymentContent::query()->withTranslations()->first()
        ];
    }

    public function getPaymentContents()
    {
        return [
            'paymentContent' => PaymentContent::query()->withTranslations()->get()
        ];
    }
}
