<?php

namespace Database\Seeders;

use App\Models\HomeContent;
use App\Services\TranslateService;
use Illuminate\Database\Seeder;

class HomeContentSeeder extends Seeder
{
    private TranslateService $translateService;

    public function __construct(TranslateService $translateService)
    {
        $this->translateService = $translateService;
    }

    public function run(): void
    {
        $homeContents = [
            [
                'title' => [
                    'ru' => 'Компания Company',
                    'en' => 'Компания Company',
                ],
                'description' => [
                    'ru' => 'Lorem Ipsum - это текст-"рыба", часто используемый в печати и вэб-дизайне. Lorem Ipsum является стандартной "рыбой" для текстов на латинице с начала XVI века.Lorem Ipsum - это текст-"рыба"

Lorem Ipsum - это текст-"рыба", часто используемый в печати и вэб-дизайне. Lorem Ipsum является стандартной "рыбой" для текстов на латинице с начала XVI века.Lorem Ipsum - это текст-"рыба"',
                    'en' => 'Lorem Ipsum - это текст-"рыба", часто используемый в печати и вэб-дизайне. Lorem Ipsum является стандартной "рыбой" для текстов на латинице с начала XVI века.Lorem Ipsum - это текст-"рыба"

Lorem Ipsum - это текст-"рыба", часто используемый в печати и вэб-дизайне. Lorem Ipsum является стандартной "рыбой" для текстов на латинице с начала XVI века.Lorem Ipsum - это текст-"рыба"',
                ],
            ],
        ];

        foreach ($homeContents as $homeContent) {
            HomeContent::query()
                ->create([
                    'title' => $this->translateService->createTranslate($homeContent['title']),
                    'description' => $this->translateService->createTranslate($homeContent['description']),
                ]);
            unset($homeContent);
        }
    }
}
