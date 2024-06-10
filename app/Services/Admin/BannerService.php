<?php

namespace App\Services\Admin;

use App\Models\Banner;
use App\Models\Translate;

class BannerService extends Service
{
    public function getBanners(): array
    {
        return [
            'banners' => Banner::query()->withTranslations()->get()
        ];
    }

    public function createData(): array
    {
        return [
            'lastPosition' => Banner::lastPosition()
        ];
    }

    public function create(array $data)
    {
        return Banner::query()
            ->create([
                'image' => $this->translateService->createTranslateFile($data['image'], Banner::IMAGE_PATH),
                'mobile_image' => $this->translateService->createTranslateFile($data['mobile_image'], Banner::IMAGE_PATH),
                'is_active' => $data['is_active'] ?? 0,
                'position' => $data['position'] ?? Banner::lastPosition(),
            ]);
    }

    public function update(Banner $banner, array $data)
    {
        if (isset($data['image'])) {
            $this->translateService->updateTranslateFile($data['image'], Banner::IMAGE_PATH, $banner->image);
        }

        if (isset($data['mobile_image'])) {
            $this->translateService->updateTranslateFile($data['mobile_image'], Banner::IMAGE_PATH, $banner->mobile_image);
        }
        $banner->is_active = $data['is_active'] ?? 0;
        $banner->position = $data['position'] ?? Banner::lastPosition();
        return $banner->save();
    }

    public function delete(Banner $banner)
    {
        if ($banner->imageTranslate) {
            foreach (Translate::LANGUAGES as $language) {
                if ($banner->imageTranslate->{$language} != null) {
                    $this->fileService->deleteFile($banner->imageTranslate->{$language}, Banner::IMAGE_PATH);
                }
            }
            $banner->imageTranslate?->delete();
        }

        if ($banner->mobileImageTranslate) {
            foreach (Translate::LANGUAGES as $language) {
                if ($banner->mobileImageTranslate->{$language} != null) {
                    $this->fileService->deleteFile($banner->mobileImageTranslate->{$language}, Banner::IMAGE_PATH);
                }
            }
            $banner->mobileImageTranslate?->delete();
        }
        return $banner->delete();
    }

    public function deleteImage(Banner $banner, array $data): int
    {
        if ($data['banner_type'] == 'desktop') {
            $image = $banner->imageTranslate->{$data['language']};
            $this->fileService->deleteFile($image, Banner::IMAGE_PATH);
            $banner->imageTranslate->{$data['language']} = null;
            $banner->imageTranslate->save();
        } else {
            $mobileImage = $banner->mobileImageTranslate->{$data['language']};
            $this->fileService->deleteFile($mobileImage, Banner::IMAGE_PATH);
            $banner->mobileImageTranslate->{$data['language']} = null;
            $banner->mobileImageTranslate->save();
        }
        return 1;
    }
}
