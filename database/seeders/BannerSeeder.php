<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Services\FileService;
use App\Services\TranslateService;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
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
        $imageMainPath = public_path('adminlte-assets/dist/img/banners/');
        $banners = [
            [
                'image' => [
                    'ru' => $this->fileService->createUploadedFile($imageMainPath . 'default-image.png'),
                    'en' => $this->fileService->createUploadedFile($imageMainPath . 'default-image.png')
                ],
                'mobile_image' => [
                    'ru' => $this->fileService->createUploadedFile($imageMainPath . 'default-image.png'),
                    'en' => $this->fileService->createUploadedFile($imageMainPath . 'default-image.png')
                ]
            ],
        ];


        $index = 1;
        foreach ($banners as $banner) {
            Banner::query()
                ->create([
                    'image' => $this->translateService->createTranslateFile($banner['image'], Banner::IMAGE_PATH),
                    'mobile_image' => $this->translateService->createTranslateFile($banner['mobile_image'], Banner::IMAGE_PATH),
                    'position' => $index
                ]);
            $index = $index + 1;
            unset($social);
        }
    }
}
