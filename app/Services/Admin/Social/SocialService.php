<?php

namespace App\Services\Admin\Social;

use App\Models\Social;
use App\Services\Admin\Service;

class SocialService extends Service
{
    public function create(array $data)
    {
        return Social::query()
            ->create([
                'image' => isset($data['image']) ? $this->fileService->saveFile($data['image'], Social::IMAGE_PATH) : null,
                'link' => $data['link'] ?? null,
                'is_active' => $data['is_active'] ?? 0,
            ]);
    }

    public function update(Social $social, array $data)
    {
        if (isset($data['image'])) {
            $social->image = $this->fileService->saveFile($data['image'], Social::IMAGE_PATH, $social->image);
        }
        $social->link = $data['link'] ?? null;
        $social->is_active = $data['is_active'] ?? 0;
        return $social->save();
    }

    public function delete(Social $social)
    {
        if ($social->image != null) {
            $this->fileService->deleteFile($social->image, Social::IMAGE_PATH);
        }
        return $social->delete();
    }
}
