<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use App\Services\FileService;
use App\Services\TranslateService;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    private TranslateService $translateService;
    protected FileService $fileService;

    public function __construct(TranslateService $translateService, FileService $fileService)
    {
        $this->fileService = $fileService;
        $this->translateService = $translateService;
    }

    public function run(): void
    {
        $imageMainPath = public_path('adminlte-assets/dist/img/payment-methods/');
        $paymentMethods = [
            [
                'title' => [
                    'ru' => 'Наличный расчет',
                    'en' => 'Наличный расчет',
                ],
                'description' => [
                    'ru' => 'Оплата наличными курьеру при получении товара или оплата в офисе при самовывозе.',
                    'en' => 'Оплата наличными курьеру при получении товара или оплата в офисе при самовывозе.',
                ],
                'image' => $this->fileService->createUploadedFile($imageMainPath . 'image-1.png'),
            ],
            [
                'title' => [
                    'ru' => 'Безналичный расчет',
                    'en' => 'Безналичный расчет',
                ],
                'description' => [
                    'ru' => 'Оплата по безналичному расчету на основании счета. Счет формируется автоматически при оформлении заказа на сайте.',
                    'en' => 'Оплата по безналичному расчету на основании счета. Счет формируется автоматически при оформлении заказа на сайте.',
                ],
                'image' => $this->fileService->createUploadedFile($imageMainPath . 'image-2.png'),
            ],
        ];


        $index = 1;
        foreach ($paymentMethods as $paymentMethod) {
            PaymentMethod::query()
                ->create([
                    'title' => $this->translateService->createTranslate($paymentMethod['title']),
                    'description' => $this->translateService->createTranslate($paymentMethod['description']),
                    'image' => $this->fileService->saveFile($paymentMethod['image'], PaymentMethod::IMAGE_PATH),
                    'position' => $index
                ]);
            $index = $index + 1;
            unset($paymentMethod);
        }
    }
}
