<?php

namespace App\Services\Api\V1;

use App\Models\User;

class AuthService
{
    public function createUser(array $data)
    {
        return User::query()
            ->create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'password' => $data['password'],
            ])
            ->assignRole('user');
    }

    public function createToken(User $user)
    {
        return [
            'token' => $user->createToken(config('app.name'), ['*'], now()->addDays(7))->toArray(),
            'user' => $user
        ];
    }
}
