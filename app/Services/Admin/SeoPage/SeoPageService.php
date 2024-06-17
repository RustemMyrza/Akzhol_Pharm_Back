<?php

namespace App\Services\Admin\SeoPage;

use App\Models\SeoPage;
use App\Services\Admin\Service;
use Illuminate\Support\Facades\Log;

class SeoPageService extends Service
{
    public function create(array $data)
    {
        return SeoPage::query()
            ->create([
                'title' => $this->translateService->createTranslate($data['title']),
                'is_active' => $data['is_active'] ?? 0,
                'position' => $data['position'] ?? SeoPage::lastPosition(),
                'page' => $data['page'],
                'meta_title' => $this->translateService->createTranslate($data['meta_title']),
                'meta_description' => $this->translateService->createTranslate($data['meta_description']),
                'meta_keyword' => $this->translateService->createTranslate($data['meta_keyword'])
            ]);
    }

    public function update(SeoPage $seoPage, array $data)
    {
        $seoPage->meta_title = $this->translateService->updateTranslate($seoPage->meta_title, $data['meta_title']);
        $seoPage->meta_description = $this->translateService->updateTranslate($seoPage->meta_description, $data['meta_description']);
        $seoPage->meta_keyword = $this->translateService->updateTranslate($seoPage->meta_keyword, $data['meta_keyword']);
        if (isset($data['page']))
        {
            $seoPage->page = $data['page'];
        }
        $seoPage->title = $this->translateService->updateTranslate($seoPage->title, $data['title']);
        $seoPage->is_active = $data['is_active'] ?? 0;
        $seoPage->position = $data['position'] ?? SeoPage::lastPosition();
        return $seoPage->save();
    }

    public function delete(SeoPage $staticSeoPage)
    {
        $staticSeoPage->metaTitleTranslate?->delete();
        $staticSeoPage->metaDescriptionTranslate?->delete();
        $staticSeoPage->metaKeywordTranslate?->delete();
        $staticSeoPage->titleTranslate?->delete();
        return $staticSeoPage->delete();
    }

    public function getSeoPages()
    {
        return SeoPage::query()
            ->withTranslations()
            ->get();
    }
}
