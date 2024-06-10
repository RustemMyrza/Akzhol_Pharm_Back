<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\SubCategory;
use App\Services\TranslateService;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    private TranslateService $translateService;

    public function __construct(TranslateService $translateService)
    {
        $this->translateService = $translateService;
    }

    public function run(): void
    {
        $categories = [
            [
                'title' => [
                    'ru' => 'Насосы',
                    'en' => 'Насосы',
                ],
                'subCategories' => [
                    [
                        'title' => [
                            'ru' => 'Трехфазные с регулируемой частотой вращения',
                            'en' => 'Трехфазные с регулируемой частотой вращения',
                        ]
                    ],
                    [
                        'title' => [
                            'ru' => 'Однофазные',
                            'en' => 'Однофазные',
                        ]
                    ],
                ]
            ],
            [
                'title' => [
                    'ru' => 'Фильтры',
                    'en' => 'Фильтры',
                ],
                'subCategories' => [
                    [
                        'title' => [
                            'ru' => 'Песочные фильтры',
                            'en' => 'Песочные фильтры',
                        ]
                    ],
                    [
                        'title' => [
                            'ru' => 'Картриджные фильтры',
                            'en' => 'Картриджные фильтры',
                        ]
                    ],
                ]
            ],
            [
                'title' => [
                    'ru' => 'Освещение бассейна',
                    'en' => 'Освещение бассейна',
                ],
                'subCategories' => [
                    [
                        'title' => [
                            'ru' => 'Накладные прожектора',
                            'en' => 'Накладные прожектора',
                        ]
                    ],
                    [
                        'title' => [
                            'ru' => 'Встраиваемые прожектора',
                            'en' => 'Встраиваемые прожектора',
                        ]
                    ],
                ]
            ],
            [
                'title' => [
                    'ru' => 'Закладные детали',
                    'en' => 'Закладные детали',
                ],
                'subCategories' => []
            ],
            [
                'title' => [
                    'ru' => 'Очистка воды',
                    'en' => 'Очистка воды',
                ],
                'subCategories' => [
                    [
                        'title' => [
                            'ru' => 'Станции дозирования',
                            'en' => 'Станции дозирования',
                        ]
                    ],
                    [
                        'title' => [
                            'ru' => 'Солевые хлораторы',
                            'en' => 'Солевые хлораторы',
                        ]
                    ],
                ]
            ],
            [
                'title' => [
                    'ru' => 'Уборка бассейна',
                    'en' => 'Уборка бассейна',
                ],
                'subCategories' => [
                    [
                        'title' => [
                            'ru' => 'Робот пылесосы',
                            'en' => 'Робот пылесосы',
                        ]
                    ],
                    [
                        'title' => [
                            'ru' => 'Ручные пылесосы',
                            'en' => 'Ручные пылесосы',
                        ]
                    ],
                ]
            ],
            [
                'title' => [
                    'ru' => 'Тепловые насосы',
                    'en' => 'Тепловые насосы',
                ],
                'subCategories' => []
            ],
            [
                'title' => [
                    'ru' => 'Автоматика для бассейна',
                    'en' => 'Автоматика для бассейна',
                ],
                'subCategories' => [
                    [
                        'title' => [
                            'ru' => 'Шкафы комплексного управления',
                            'en' => 'Шкафы комплексного управления',
                        ]
                    ],
                    [
                        'title' => [
                            'ru' => 'Блоки управления фильтрацией',
                            'en' => 'Блоки управления фильтрацией',
                        ]
                    ],
                    [
                        'title' => [
                            'ru' => 'Блоки управления уровнем',
                            'en' => 'Блоки управления уровнем',
                        ]
                    ],
                    [
                        'title' => [
                            'ru' => 'Блоки управление температурой',
                            'en' => 'Блоки управление температурой',
                        ]
                    ],
                    [
                        'title' => [
                            'ru' => 'Блоки управления подсветкой',
                            'en' => 'Блоки управления подсветкой',
                        ]
                    ],
                ]
            ],
            [
                'title' => [
                    'ru' => 'Изделия из нержавеющей стали',
                    'en' => 'Изделия из нержавеющей стали',
                ],
                'subCategories' => []
            ],
            [
                'title' => [
                    'ru' => 'Запасные части для оборудования',
                    'en' => 'Запасные части для оборудования',
                ],
                'subCategories' => []
            ],
        ];

        $index = 1;
        foreach ($categories as $category) {
            $newCategory = Category::query()
                ->create([
                    'title' => $this->translateService->createTranslate($category['title']),
                    'position' => $index,
                    'is_important' => $index == 1 ? 1 : 0,
                    'meta_title' => $this->translateService->createTranslate($category['title']),
                    'meta_description' => $this->translateService->createTranslate($category['title']),
                    'meta_keyword' => $this->translateService->createTranslate($category['title'])
                ]);

            if (count($category['subCategories'])) {
                $indexSubCategory = 1;
                foreach ($category['subCategories'] as $subCategory) {
                    SubCategory::query()
                        ->create([
                            'category_id' => $newCategory->id,
                            'title' => $this->translateService->createTranslate($subCategory['title']),
                            'position' => $indexSubCategory
                        ]);
                    $indexSubCategory++;
                }
            }

            unset($category);
            $index = $index + 1;
        }
    }
}
