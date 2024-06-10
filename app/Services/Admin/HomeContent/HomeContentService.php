<?php

namespace App\Services\Admin\HomeContent;

use App\Models\HomeContent;
use App\Services\Admin\Service;

class HomeContentService extends Service
{
    public function create(array $data)
    {
        return HomeContent::query()
            ->create([
                'title' => $this->translateService->createTranslate($data['title']),
                'description' => $this->translateService->createTranslate($data['description']),
            ]);
    }

    public function update(HomeContent $homeContent, array $data)
    {
        $homeContent->title = $this->translateService->updateTranslate($homeContent->title, $data['title']);
        $homeContent->description = $this->translateService->updateTranslate($homeContent->description, $data['description']);
        return $homeContent->save();
    }

    public function getHomeContent()
    {
        return [
            'homeContent' => HomeContent::query()->withTranslations()->first()
        ];
    }

    public function getHomeContents()
    {
        return [
            'homeContents' => HomeContent::query()->withTranslations()->get()
        ];
    }
}
