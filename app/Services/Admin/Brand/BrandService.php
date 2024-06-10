<?php

namespace App\Services\Admin\Brand;

use App\Models\Brand;
use App\Services\Admin\Service;

class BrandService extends Service
{
    public function getBrands()
    {
        return Brand::query()
            ->withTranslations()
            ->orderBy('position')
            ->orderBy('id')
            ->paginate();
    }

    public function create(array $data)
    {
        return Brand::query()
            ->create([
                'title' => $this->translateService->createTranslate($data['title']),
                'is_active' => $data['is_active'] ?? 0,
                'position' => $data['position'] ?? Brand::lastPosition(),
            ]);
    }

    public function update(Brand $country, array $data)
    {
        $country->title = $this->translateService->updateTranslate($country->title, $data['title']);
        $country->is_active = $data['is_active'] ?? 0;
        $country->position = $data['position'] ?? Brand::lastPosition();
        return $country->save();
    }

    public function delete(Brand $country)
    {
        $country->titleTranslate?->delete();
        return $country->delete();
    }
}
