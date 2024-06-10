<?php

namespace Database\Seeders;

use App\Models\Filter;
use App\Models\FilterItem;
use App\Services\TranslateService;
use Illuminate\Database\Seeder;

class FilterSeeder extends Seeder
{
    private TranslateService $translateService;

    public function __construct(TranslateService $translateService)
    {
        $this->translateService = $translateService;
    }

    public function run(): void
    {
        $filters = [
            [
                'title' => [
                    'ru' => 'Оборудование для басейнов',
                    'en' => 'Оборудование для басейнов',
                ],
                'position' => 1,
                'filter_items' => [
                    [
                        'title' => [
                            'ru' => 'Оборудование для дизинфекции воды',
                            'en' => 'Оборудование для дизинфекции воды',
                        ],
                    ],
                    [
                        'title' => [
                            'ru' => 'Фильтры и фильтровальные установки',
                            'en' => 'Фильтры и фильтровальные установки',
                        ],
                    ],
                    [
                        'title' => [
                            'ru' => 'Уход за бассейном',
                            'en' => 'Уход за бассейном',
                        ],
                    ],
                ]
            ],
            [
                'title' => [
                    'ru' => 'Для строительства бассейнов',
                    'en' => 'Для строительства бассейнов',
                ],
                'position' => 2,
                'filter_items' => [
                    [
                        'title' => [
                            'ru' => 'Закладные детали',
                            'en' => 'Закладные детали',
                        ],
                    ],
                    [
                        'title' => [
                            'ru' => 'Освещение для бассейнов',
                            'en' => 'Освещение для бассейнов',
                        ],
                    ],
                    [
                        'title' => [
                            'ru' => 'Запчасти и аксесуары',
                            'en' => 'Запчасти и аксесуары',
                        ],
                    ],
                ]
            ],
            [
                'title' => [
                    'ru' => 'Другие производители',
                    'en' => 'Другие производители',
                ],
                'position' => 3,
                'filter_items' => [
                    [
                        'title' => [
                            'ru' => 'Бассейны и аксесуары',
                            'en' => 'Бассейны и аксесуары',
                        ],
                    ],
                    [
                        'title' => [
                            'ru' => 'Для строительства бассейнов',
                            'en' => 'Для строительства бассейнов',
                        ],
                    ],
                    [
                        'title' => [
                            'ru' => 'Оборудование для бассейнов',
                            'en' => 'Оборудование для бассейнов',
                        ],
                    ],
                    [
                        'title' => [
                            'ru' => 'Отопление и водоподготовка',
                            'en' => 'Отопление и водоподготовка',
                        ],
                    ],
                    [
                        'title' => [
                            'ru' => 'Трубопроводные системы ПВХ',
                            'en' => 'Трубопроводные системы ПВХ',
                        ],
                    ],
                ]
            ],
        ];

        foreach ($filters as $filter) {
            $newFilter = Filter::query()
                ->create([
                    'title' => $this->translateService->createTranslate($filter['title']),
                    'position' => $filter['position'],
                ]);

            $index = 1;
            foreach ($filter['filter_items'] as $filterItem) {
                FilterItem::query()
                    ->create([
                        'title' => $this->translateService->createTranslate($filterItem['title']),
                        'filter_id' => $newFilter->id,
                        'position' => $index,
                    ]);
                $index = $index + 1;
                unset($filterItem);
            }

            unset($filter);
        }
    }
}
