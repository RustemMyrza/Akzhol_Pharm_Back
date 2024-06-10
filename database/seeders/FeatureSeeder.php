<?php

namespace Database\Seeders;

use App\Models\Feature;
use App\Models\FeatureItem;
use App\Services\TranslateService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FeatureSeeder extends Seeder
{
    private TranslateService $translateService;

    public function __construct(TranslateService $translateService)
    {
        $this->translateService = $translateService;
    }

    public function run(): void
    {
        $features = [
            [
                'title' => [
                    'ru' => 'Производитель',
                    'en' => 'Производитель',
                ],
                'feature_items' => [
                    [
                        'title' => [
                            'ru' => 'Aquaviva',
                            'en' => 'Aquaviva',
                        ],
                    ],
                    [
                        'title' => [
                            'ru' => 'Bestway',
                            'en' => 'Bestway',
                        ],
                    ],
                    [
                        'title' => [
                            'ru' => 'Hayward',
                            'en' => 'Hayward',
                        ],
                    ],
                    [
                        'title' => [
                            'ru' => 'AquaDoctor',
                            'en' => 'AquaDoctor',
                        ],
                    ],
                ]
            ],
            [
                'title' => [
                    'ru' => 'Страна производства',
                    'en' => 'Страна производства',
                ],
                'feature_items' => [
                    [
                        'title' => [
                            'ru' => 'Казахстан',
                            'en' => 'Казахстан',
                        ],
                    ],
                    [
                        'title' => [
                            'ru' => 'Россия',
                            'en' => 'Россия',
                        ],
                    ],
                    [
                        'title' => [
                            'ru' => 'Китай',
                            'en' => 'Китай',
                        ],
                    ],
                    [
                        'title' => [
                            'ru' => 'США',
                            'en' => 'США',
                        ],
                    ],
                ]
            ],
            [
                'title' => [
                    'ru' => 'Гарантия',
                    'en' => 'Гарантия',
                ],
                'feature_items' => [
                    [
                        'title' => [
                            'ru' => '1 год',
                            'en' => '1 год',
                        ],
                    ],
                    [
                        'title' => [
                            'ru' => '2 год',
                            'en' => '2 год',
                        ],
                    ],
                    [
                        'title' => [
                            'ru' => '3 год',
                            'en' => '3 год',
                        ],
                    ],
                    [
                        'title' => [
                            'ru' => '4 год',
                            'en' => '4 год',
                        ],
                    ],
                ]
            ],
            [
                'title' => [
                    'ru' => 'Толщина мембраны',
                    'en' => 'Толщина мембраны',
                ],
                'feature_items' => [
                    [
                        'title' => [
                            'ru' => '1.5 мм',
                            'en' => '1.5 мм',
                        ],
                    ],
                ]
            ],
            [
                'title' => [
                    'ru' => 'Предел прочности',
                    'en' => 'Предел прочности',
                ],
                'feature_items' => [
                    [
                        'title' => [
                            'ru' => 'MD  1300N/5см, TD  1300N/5см',
                            'en' => 'MD  1300N/5см, TD  1300N/5см',
                        ],
                    ],
                ]
            ],
            [
                'title' => [
                    'ru' => 'Относительное удлинение при разрыве',
                    'en' => 'Относительное удлинение при разрыве',
                ],
                'feature_items' => [
                    [
                        'title' => [
                            'ru' => 'MD  16%, TD  16%',
                            'en' => 'MD  16%, TD  16%',
                        ],
                    ],
                ]
            ],
            [
                'title' => [
                    'ru' => 'Прочность на разрыв',
                    'en' => 'Прочность на разрыв',
                ],
                'feature_items' => [
                    [
                        'title' => [
                            'ru' => 'MD  250N, TD  250N',
                            'en' => 'MD  250N, TD  250N',
                        ],
                    ],
                ]
            ],
            [
                'title' => [
                    'ru' => 'Стабильность размеров',
                    'en' => 'Стабильность размеров',
                ],
                'feature_items' => [
                    [
                        'title' => [
                            'ru' => 'MD < 1%, TD < 1%',
                            'en' => 'MD < 1%, TD < 1%',
                        ],
                    ],
                ]
            ],
            [
                'title' => [
                    'ru' => 'Прочность сцепления',
                    'en' => 'Прочность сцепления',
                ],
                'feature_items' => [
                    [
                        'title' => [
                            'ru' => 'MD < 1%, TD < 1%',
                            'en' => 'MD < 1%, TD < 1%',
                        ],
                    ],
                ]
            ],
        ];

        DB::beginTransaction();
        foreach ($features as $featureIndex => $feature) {
            $featureIndex = $featureIndex + 1;
            $newFeature = Feature::query()
                ->create([
                    'title' => $this->translateService->createTranslate($feature['title']),
                    'position' => $featureIndex,
                ]);

            $featureItemIndex = 1;
            foreach ($feature['feature_items'] as $featureItem) {
                FeatureItem::query()
                    ->create([
                        'title' => $this->translateService->createTranslate($featureItem['title']),
                        'feature_id' => $newFeature->id,
                        'position' => $featureItemIndex,
                    ]);
                $featureItemIndex = $featureItemIndex + 1;
                unset($featureItem);
            }
            unset($feature);
        }
        DB::commit();
    }
}
