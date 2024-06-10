<?php

namespace Database\Seeders;

use App\Models\SeoPage;
use App\Services\TranslateService;
use Illuminate\Database\Seeder;

class SeoPageSeeder extends Seeder
{
    private TranslateService $translateService;

    public function __construct(TranslateService $translateService)
    {
        $this->translateService = $translateService;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $seoPages = [
            [
                'title' => [
                    'ru' => 'Главная',
                    'en' => 'Главная',
                ],
                'page' => '/',
                'meta_title' => [
                    'ru' => 'Главная страница',
                    'en' => 'Главная страница',
                ],
                'meta_description' => [
                    'ru' => 'Главная страница',
                    'en' => 'Главная страница',
                ],
                'meta_keyword' => [
                    'ru' => 'Главная страница',
                    'en' => 'Главная страница',
                ],
            ],
            [
                'title' => [
                    'ru' => 'Каталог',
                    'en' => 'Каталог',
                ],
                'page' => 'catalog',
                'meta_title' => [
                    'ru' => 'catalog',
                    'en' => 'catalog',
                ],
                'meta_description' => [
                    'ru' => 'catalog',
                    'en' => 'catalog',
                ],
                'meta_keyword' => [
                    'ru' => 'catalog',
                    'en' => 'catalog',
                ],
            ],
            [
                'title' => [
                    'ru' => 'Документация',
                    'en' => 'Документация',
                ],
                'page' => 'instructions',
                'meta_title' => [
                    'ru' => 'Документация',
                    'en' => 'Документация',
                ],
                'meta_description' => [
                    'ru' => 'Документация',
                    'en' => 'Документация',
                ],
                'meta_keyword' => [
                    'ru' => 'Документация',
                    'en' => 'Документация',
                ],
            ],
            [
                'title' => [
                    'ru' => 'Оплата',
                    'en' => 'Оплата',
                ],
                'page' => 'payment',
                'meta_title' => [
                    'ru' => 'Оплата',
                    'en' => 'Оплата',
                ],
                'meta_description' => [
                    'ru' => 'Оплата',
                    'en' => 'Оплата',
                ],
                'meta_keyword' => [
                    'ru' => 'Оплата',
                    'en' => 'Оплата',
                ],
            ],
            [
                'title' => [
                    'ru' => 'Доставка',
                    'en' => 'Доставка',
                ],
                'page' => 'delivery',
                'meta_title' => [
                    'ru' => 'Доставка',
                    'en' => 'Доставка',
                ],
                'meta_description' => [
                    'ru' => 'Доставка',
                    'en' => 'Доставка',
                ],
                'meta_keyword' => [
                    'ru' => 'Доставка',
                    'en' => 'Доставка',
                ],
            ],
            [
                'title' => [
                    'ru' => 'О компании',
                    'en' => 'О компании',
                ],
                'page' => 'about',
                'meta_title' => [
                    'ru' => 'О компании',
                    'en' => 'О компании',
                ],
                'meta_description' => [
                    'ru' => 'О компании',
                    'en' => 'О компании',
                ],
                'meta_keyword' => [
                    'ru' => 'О компании',
                    'en' => 'О компании',
                ],
            ],
            [
                'title' => [
                    'ru' => 'Диллеры',
                    'en' => 'Диллеры',
                ],
                'page' => 'dealers',
                'meta_title' => [
                    'ru' => 'Диллеры',
                    'en' => 'Диллеры',
                ],
                'meta_description' => [
                    'ru' => 'Диллеры',
                    'en' => 'Диллеры',
                ],
                'meta_keyword' => [
                    'ru' => 'Диллеры',
                    'en' => 'Диллеры',
                ],
            ],
            [
                'title' => [
                    'ru' => 'Контакты',
                    'en' => 'Контакты',
                ],
                'page' => 'contacts',
                'meta_title' => [
                    'ru' => 'Контакты',
                    'en' => 'Контакты',
                ],
                'meta_description' => [
                    'ru' => 'Контакты',
                    'en' => 'Контакты',
                ],
                'meta_keyword' => [
                    'ru' => 'Контакты',
                    'en' => 'Контакты',
                ],
            ],
        ];

        $index = 1;
        foreach ($seoPages as $seoPage) {
            SeoPage::query()
                ->create([
                    'title' => $this->translateService->createTranslate($seoPage['title']),
                    'page' => $seoPage['page'],
                    'position' => $index,
                    'meta_title' => $this->translateService->createTranslate($seoPage['meta_title']),
                    'meta_description' => $this->translateService->createTranslate($seoPage['meta_description']),
                    'meta_keyword' => $this->translateService->createTranslate($seoPage['meta_keyword'])
                ]);
            $index = $index + 1;
            unset($seoPage);
        }
    }
}
