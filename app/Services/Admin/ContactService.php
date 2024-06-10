<?php

namespace App\Services\Admin;

use App\Models\Contact;

class ContactService extends Service
{
    public function create(array $data)
    {
        return Contact::query()
            ->create([
                'address' => $this->translateService->createTranslate($data['address']),
                'work_time' => $this->translateService->createTranslate($data['work_time']),
                'email' => $data['email'],
                'phone' => $data['phone'],
                'phone_2' => $data['phone_2'] ?? null,
                'map_link' => $data['map_link'] ?? null,
            ]);
    }

    public function update(Contact $contact, array $data)
    {
        $contact->address = $this->translateService->updateTranslate($contact->address, $data['address']);
        $contact->work_time = $this->translateService->updateTranslate($contact->work_time, $data['work_time']);
        $contact->email = $data['email'];
        $contact->phone = $data['phone'];
        $contact->phone_2 = $data['phone_2'];
        $contact->map_link = $data['map_link'];

        return $contact->save();
    }
}
