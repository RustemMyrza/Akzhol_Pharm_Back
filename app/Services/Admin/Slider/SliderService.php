<?php

namespace App\Services\Admin\Slider;

use App\Models\Slider;
use App\Services\Admin\Service;

class SliderService extends Service
{
    public function getSliders()
    {
        return Slider::query()
            ->withTranslations()
            ->paginate();
    }

    public function create(array $data)
    {
        return Slider::query()
            ->create([
                'title' => $this->translateService->createTranslate($data['title']),
                'description' => $this->translateService->createTranslate($data['description']),
                'image' => isset($data['image']) ? $this->fileService->saveFile($data['image'], Slider::IMAGE_PATH) : null,
                'is_active' => $data['is_active'] ?? 0,
                'position' => $data['position'] ?? Slider::lastPosition(),
            ]);
    }

    public function update(Slider $slider, array $data)
    {
        $slider->title = $this->translateService->updateTranslate($slider->title, $data['title']);
        $slider->description = $this->translateService->updateTranslate($slider->description, $data['description']);
        if (isset($data['image'])) {
            $slider->image = $this->fileService->saveFile($data['image'], Slider::IMAGE_PATH, $slider->image);
        }
        $slider->is_active = $data['is_active'] ?? 0;
        $slider->position = $data['position'] ?? Slider::lastPosition();
        return $slider->save();
    }

    public function delete(Slider $slider)
    {
        $slider->titleTranslate?->delete();
        $slider->descriptionTranslate?->delete();
        if ($slider->image) {
            $this->fileService->deleteFile($slider->image, Slider::IMAGE_PATH);
        }
        return $slider->delete();
    }
}
