<?php

namespace App\Services\Admin\DealerContent;

use App\Models\DealerContent;
use App\Services\Admin\Service;

class DealerContentService extends Service
{
    public function create(array $data)
    {
        return DealerContent::query()
            ->create([
                'description' => $this->translateService->createTranslate($data['description']),
                'email' => $data['email'],
                'phone' => $data['phone'],
            ]);
    }

    public function update(DealerContent $dealerContent, array $data)
    {
        $dealerContent->description = $this->translateService->updateTranslate($dealerContent->description, $data['description']);
        $dealerContent->email = $data['email'];
        $dealerContent->phone = $data['phone'];
        return $dealerContent->save();
    }

    public function getDealerContent()
    {
        return [
            'dealerContent' => DealerContent::query()->withTranslations()->first()
        ];
    }

    public function getDealerContents()
    {
        return [
            'dealerContents' => DealerContent::query()->withTranslations()->get()
        ];
    }
}
