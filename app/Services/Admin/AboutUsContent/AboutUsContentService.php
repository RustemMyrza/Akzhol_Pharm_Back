<?php

namespace App\Services\Admin\AboutUsContent;

use App\Models\AboutUsContent;
use App\Services\Admin\Service;

class AboutUsContentService extends Service
{
    public function create(array $data)
    {
        return AboutUsContent::query()
            ->create([
                'description' => $this->translateService->createTranslate($data['description']),
                'content' => $this->translateService->createTranslate($data['content']),
                'image' => isset($data['image']) ? $this->fileService->saveFile($data['image'], AboutUsContent::IMAGE_PATH) : null,
            ]);
    }

    public function update(AboutUsContent $aboutUsContent, array $data)
    {
        $aboutUsContent->description = $this->translateService->updateTranslate($aboutUsContent->description, $data['description']);
        $aboutUsContent->content = $this->translateService->updateTranslate($aboutUsContent->content, $data['content']);
        if (isset($data['image'])) {
            $aboutUsContent->image = $this->fileService->saveFile($data['image'], AboutUsContent::IMAGE_PATH, $aboutUsContent->image);
        }
        return $aboutUsContent->save();
    }

    public function delete(AboutUsContent $aboutUsContent)
    {
        $aboutUsContent->descriptionTranslate?->delete();
        $aboutUsContent->contentTranslate?->delete();
        if ($aboutUsContent->image) {
            $this->fileService->deleteFile($aboutUsContent->image, AboutUsContent::IMAGE_PATH);
        }
        return $aboutUsContent->delete();
    }

    public function deleteImage(AboutUsContent $aboutUsContent)
    {
        if ($aboutUsContent->image) {
            $this->fileService->deleteFile($aboutUsContent->image, AboutUsContent::IMAGE_PATH);
        }
        return $aboutUsContent->update(['image' => null]);
    }

    public function getAboutUsContent()
    {
        return [
            'aboutUsContent' => AboutUsContent::query()->withTranslations()->first()
        ];
    }

    public function getAboutUsContents()
    {
        return [
            'aboutUsContents' => AboutUsContent::query()->withTranslations()->get()
        ];
    }
}
