<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Services\TranslateService;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    private TranslateService $translateService;

    public function __construct(TranslateService $translateService)
    {
        $this->translateService = $translateService;
    }

    public function run(): void
    {
        $brands = [
            [
                'title' => [
                    'ru' => 'Aquaviva',
                    'en' => 'Aquaviva',
                ],
                'position' => 1
            ],
            [
                'title' => [
                    'ru' => 'Bestway',
                    'en' => 'Bestway',
                ],
                'position' => 2
            ],
            [
                'title' => [
                    'ru' => 'Hayward',
                    'en' => 'Hayward',
                ],
                'position' => 3
            ],
            [
                'title' => [
                    'ru' => 'AquaDoctor',
                    'en' => 'AquaDoctor',
                ],
                'position' => 4
            ],
            [
                'title' => [
                    'ru' => 'Aquant',
                    'en' => 'Aquant',
                ],
                'position' => 5
            ],
        ];

        foreach ($brands as $brand) {
            Brand::query()
                ->create([
                    'title' => $this->translateService->createTranslate($brand['title']),
                    'position' => $brand['position']
                ]);
            unset($brand);
        }
    }
}
