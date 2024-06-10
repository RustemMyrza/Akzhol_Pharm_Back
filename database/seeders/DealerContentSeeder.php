<?php

namespace Database\Seeders;

use App\Models\DealerContent;
use App\Services\TranslateService;
use Illuminate\Database\Seeder;

class DealerContentSeeder extends Seeder
{
    private TranslateService $translateService;

    public function __construct(TranslateService $translateService)
    {
        $this->translateService = $translateService;
    }

    public function run(): void
    {
        $dealerContents = [
            [
                'description' => [
                    'ru' => 'Уважаемые партнеры! Оптовым клиентам мы предоставляем большие скидки. Для торгующих и обслуживающих организаций у нас индивидуальные условия и хорошие скидки! По всем вопросам звоните по телефону, или пишите на электронную почту!',
                    'en' => 'Уважаемые партнеры! Оптовым клиентам мы предоставляем большие скидки. Для торгующих и обслуживающих организаций у нас индивидуальные условия и хорошие скидки! По всем вопросам звоните по телефону, или пишите на электронную почту!',
                ],
                'email' => '322552@gmail.com',
                'phone' => '8 707 707 07 70',
            ],
        ];


        foreach ($dealerContents as $dealerContent) {
            DealerContent::query()
                ->create([
                    'description' => $this->translateService->createTranslate($dealerContent['description']),
                    'email' => $dealerContent['email'],
                    'phone' => $dealerContent['phone'],
                ]);
            unset($dealerContent);
        }
    }
}
