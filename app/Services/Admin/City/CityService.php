<?php

namespace App\Services\Admin\City;

use App\Models\City;
use App\Services\Admin\Service;

class CityService extends Service
{
    public function getCities()
    {
        return City::query()
            ->withTranslations()
            ->get();
    }

    public function create(array $data)
    {
        return City::query()
            ->create([
                'title' => $this->translateService->createTranslate($data['title']),
                'is_active' => $data['is_active'] ?? 0,
                'position' => $data['position'] ?? City::lastPosition(),
            ]);
    }

    public function update(City $city, array $data)
    {
        $city->title = $this->translateService->updateTranslate($city->title, $data['title']);
        $city->is_active = $data['is_active'] ?? 0;
        $city->position = $data['position'] ?? City::lastPosition();
        return $city->save();
    }

    public function delete(City $city)
    {
        $city->titleTranslate?->delete();
        return $city->delete();
    }
}
