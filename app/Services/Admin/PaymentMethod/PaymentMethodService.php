<?php

namespace App\Services\Admin\PaymentMethod;

use App\Models\PaymentMethod;
use App\Services\Admin\Service;

class PaymentMethodService extends Service
{
    public function getPaymentMethods()
    {
        return [
            'paymentMethods' => PaymentMethod::query()->withTranslations()->get()
        ];
    }

    public function create(array $data)
    {
        return PaymentMethod::query()
            ->create([
                'title' => $this->translateService->createTranslate($data['title']),
                'description' => $this->translateService->createTranslate($data['description']),
                'image' => isset($data['image']) ? $this->fileService->saveFile($data['image'], PaymentMethod::IMAGE_PATH) : null,
                'is_active' => $data['is_active'] ?? 0,
                'position' => $data['position'] ?? PaymentMethod::lastPosition(),
            ]);
    }

    public function update(PaymentMethod $paymentMethod, array $data)
    {
        $paymentMethod->title = $this->translateService->updateTranslate($paymentMethod->title, $data['title']);
        $paymentMethod->description = $this->translateService->updateTranslate($paymentMethod->description, $data['description']);
        if (isset($data['image'])) {
            $paymentMethod->image = $this->fileService->saveFile($data['image'], PaymentMethod::IMAGE_PATH, $paymentMethod->image);
        }
        $paymentMethod->is_active = $data['is_active'] ?? 0;
        $paymentMethod->position = $data['position'] ?? PaymentMethod::lastPosition();
        return $paymentMethod->save();
    }

    public function delete(PaymentMethod $paymentMethod)
    {
        $paymentMethod->titleTranslate?->delete();
        $paymentMethod->descriptionTranslate?->delete();
        if ($paymentMethod->image) {
            $this->fileService->deleteFile($paymentMethod->image, PaymentMethod::IMAGE_PATH);
        }
        return $paymentMethod->delete();
    }
}
