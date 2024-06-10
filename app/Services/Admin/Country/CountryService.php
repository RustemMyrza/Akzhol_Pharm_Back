<?php

namespace App\Services\Admin\Country;

use App\Models\Country;
use App\Services\Admin\Service;

class CountryService extends Service
{
    public function getCountries()
    {
        return Country::query()
            ->withTranslations()
            ->orderBy('position')
            ->orderBy('id')
            ->paginate();
    }

    public function create(array $data)
    {
        return Country::query()
            ->create([
                'title' => $this->translateService->createTranslate($data['title']),
                'is_active' => $data['is_active'] ?? 0,
                'position' => $data['position'] ?? Country::lastPosition(),
            ]);
    }

    public function update(Country $country, array $data)
    {
        $country->title = $this->translateService->updateTranslate($country->title, $data['title']);
        $country->is_active = $data['is_active'] ?? 0;
        $country->position = $data['position'] ?? Country::lastPosition();
        return $country->save();
    }

    public function delete(Country $country)
    {
        $country->titleTranslate?->delete();
        return $country->delete();
    }
}
