<?php

namespace Database\Seeders;

use App\Models\City;
use App\Services\TranslateService;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    private TranslateService $translateService;

    public function __construct(TranslateService $translateService)
    {
        $this->translateService = $translateService;
    }

    public function run(): void
    {
        $cities = [
            ['title' => ['ru' => 'Алматы', 'en' => 'Алматы']],
            ['title' => ['ru' => 'Шымкент', 'en' => 'Шымкент']],
            ['title' => ['ru' => 'Астана', 'en' => 'Астана']],
            ['title' => ['ru' => 'Актобе', 'en' => 'Актобе']],
            ['title' => ['ru' => 'Караганда', 'en' => 'Караганда']],
            ['title' => ['ru' => 'Тараз (Жамбыл)', 'en' => 'Тараз (Жамбыл)']],
            ['title' => ['ru' => 'Павлодар', 'en' => 'Павлодар']],
            ['title' => ['ru' => 'Атырау', 'en' => 'Атырау']],
            ['title' => ['ru' => 'Усть-Каменогорск', 'en' => 'Усть-Каменогорск']],
            ['title' => ['ru' => 'Семей', 'en' => 'Семей']],
            ['title' => ['ru' => 'Орал', 'en' => 'Орал']],
            ['title' => ['ru' => 'Кызылорда', 'en' => 'Кызылорда']],
            ['title' => ['ru' => 'Костанай', 'en' => 'Костанай']],
            ['title' => ['ru' => 'Петропавл', 'en' => 'Петропавл']],
            ['title' => ['ru' => 'Актау', 'en' => 'Актау']],
            ['title' => ['ru' => 'Туркистан', 'en' => 'Туркистан']],
            ['title' => ['ru' => 'Кокшетау', 'en' => 'Кокшетау']],
            ['title' => ['ru' => 'Жезказган', 'en' => 'Жезказган']],
            ['title' => ['ru' => 'Талдыкорган', 'en' => 'Талдыкорган']],
        ];

        $index = 1;
        foreach ($cities as $city) {
            City::query()
                ->create([
                    'title' => $this->translateService->createTranslate($city['title']),
                    'position' => $index
                ]);
            $index = $index + 1;
            unset($city);
        }
    }
}
