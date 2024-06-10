<?php

namespace Database\Seeders;

use App\Models\Social;
use App\Services\FileService;
use Illuminate\Database\Seeder;

class SocialSeeder extends Seeder
{
    protected FileService $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function run(): void
    {
        $imageMainPath = public_path('adminlte-assets/dist/img/socials/');
        $socials = [
            [
                'link' => 'https://mail.ru',
                'image' => $this->fileService->createUploadedFile($imageMainPath . 'mail.png')
            ],
            [
                'link' => 'https://mail.google.com',
                'image' => $this->fileService->createUploadedFile($imageMainPath . 'email.png')
            ],
            [
                'link' => 'https://www.instagram.com',
                'image' => $this->fileService->createUploadedFile($imageMainPath . 'instagram.png')
            ],
        ];

        foreach ($socials as $social) {
            Social::query()
                ->create([
                    'link' => $social['link'],
                    'image' => $this->fileService->saveFile($social['image'], Social::IMAGE_PATH)
                ]);
            unset($social);
        }
    }
}
