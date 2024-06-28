<?php

namespace App\Services\Admin\ReviewContent;

use App\Models\ReviewsContent;
use App\Services\Admin\Service;

class ReviewContentService extends Service
{
    public function create(array $data)
    {
        return ReviewsContent::query()
            ->create([
                'description' => $this->translateService->createTranslate($data['description']),
                'content' => $this->translateService->createTranslate($data['content']),
            ]);
    }

    public function update(ReviewsContent $reviewContent, array $data)
    {
        $reviewContent->description = $this->translateService->updateTranslate($reviewContent->description, $data['description']);
        $reviewContent->content = $this->translateService->updateTranslate($reviewContent->content, $data['content']);
        return $reviewContent->save();
    }

    public function getReviewContent()
    {
        return [
            'reviewContent' => ReviewsContent::query()->withTranslations()->first()
        ];
    }

    public function getReviewContents()
    {
        return [
            'reviewContent' => ReviewsContent::query()->withTranslations()->get()
        ];
    }
}
