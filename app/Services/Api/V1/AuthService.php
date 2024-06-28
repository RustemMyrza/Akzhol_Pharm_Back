<?php

namespace App\Services\Api\V1;

use App\Models\Client;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function createUser(array $data)
    {
        return Client::query()
            ->create([
                'name' => $data['name'],
                'surname' => $data['surname'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
    }

    public function createToken(Client $user)
    {
        return [
            'token' => $user->createToken(config('app.name'), ['*'], now()->addDays(7))->toArray(),
            'user' => $user
        ];
    }
}
