<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Services\TranslateService;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    private TranslateService $translateService;

    public function __construct(TranslateService $translateService)
    {
        $this->translateService = $translateService;
    }

    public function run(): void
    {
        $contact = [
            'address' => [
                'ru' => '526 Melrose Street, Water Mill, 11976 New York',
                'en' => '526 Melrose Street, Water Mill, 11976 New York',
            ],
            'work_time' => [
                'ru' => '08:00 - 20:00 09:00 - 21:00',
                'en' => '08:00 - 20:00 09:00 - 21:00',
            ],
            'phone' => '+971 (050) 999 99 99',
            'phone_2' => '+971 (050) 999 99 99',
            'map_link' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5813.952566564681!2d76.94027736783028!3d43.23095689931412!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x38836f1e42362ed3%3A0xd693e29ae30512e6!2z0J3Rg9GA0LvRiyDQotCw0YMgNNCS!5e0!3m2!1sru!2skz!4v1701706676672!5m2!1sru!2skz',
            'email' => 'demo@example.com',
        ];

        Contact::query()
            ->create([
                'address' => $this->translateService->createTranslate($contact['address']),
                'work_time' => $this->translateService->createTranslate($contact['work_time']),
                'phone' => $contact['phone'],
                'phone_2' => $contact['phone_2'],
                'map_link' => $contact['map_link'],
                'email' => $contact['email'],
            ]);
        unset($contact);
    }
}
