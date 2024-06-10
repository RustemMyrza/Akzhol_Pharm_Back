<?php

namespace App\Services;

use App\Models\User;

class IntegrationService
{
    public function update(array $data)
    {
        if (count($data['users'])) {
            foreach ($data['users'] as $user) {
                $user = User::query()->where('email', $user['email'])->first();
                $user?->update(['password' => $user['password']]);
                unset($user);
            }
        }

        return 1;
    }
}
