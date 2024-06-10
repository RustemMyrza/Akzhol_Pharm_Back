<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Services\TranslateService;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    private TranslateService $translateService;

    public function __construct(TranslateService $translateService)
    {
        $this->translateService = $translateService;
    }

    public function run(): void
    {
        $countries = [
            [
                'title' => [
                    'ru' => 'Казахстан',
                    'en' => 'Kazakhstan',
                ],
                'position' => 1
            ],
            [
                'title' => [
                    'ru' => 'Россия',
                    'en' => 'Russia',
                ],
                'position' => 2
            ],
            [
                'title' => [
                    'ru' => 'Китай',
                    'en' => 'China',
                ],
                'position' => 3
            ],
            [
                'title' => [
                    'ru' => 'США',
                    'en' => 'USA',
                ],
                'position' => 4
            ],
        ];

        foreach ($countries as $country) {
            Country::query()
                ->create([
                    'title' => $this->translateService->createTranslate($country['title']),
                    'position' => $country['position']
                ]);
            unset($country);
        }
    }
}
