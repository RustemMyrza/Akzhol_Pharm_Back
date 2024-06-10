<?php

namespace App\Services\Api\V1;

use App\Models\Subscriber;
use Illuminate\Support\Str;

class SubscriberService
{
    private function generateToken(): string
    {
        return Str::random(64);
    }

    public function create(array $data)
    {
        $subscriber = Subscriber::query()
            ->where('user_id', '=', $data['user_id'])
            ->first();

        if (!$subscriber) {
            return Subscriber::query()
                ->create([
                    'user_id' => $data['user_id'],
                    'email' => $data['email'],
                    'token' => $this->generateToken(),
                    'is_news' => $data['is_news'] ?? 0,
                    'is_sales' => $data['is_sales'] ?? 0,
                    'is_promotions' => $data['is_promotions'] ?? 0,
                    'is_active' => 0
                ]);
        }

        if ($subscriber->email != $data['email']) {
            $subscriber->update([
                'is_news' => $data['is_news'] ?? 0,
                'is_sales' => $data['is_sales'] ?? 0,
                'is_promotions' => $data['is_promotions'] ?? 0,
                'token' => $this->generateToken(),
                'email_verified_at' => null
            ]);
        }

        if (!$subscriber->is_active) {
            $subscriber->update([
                'token' => $this->generateToken(),
                'is_news' => $data['is_news'] ?? 0,
                'is_sales' => $data['is_sales'] ?? 0,
                'is_promotions' => $data['is_promotions'] ?? 0,
            ]);
        } else {
            $subscriber->update([
                'is_news' => $data['is_news'] ?? 0,
                'is_sales' => $data['is_sales'] ?? 0,
                'is_promotions' => $data['is_promotions'] ?? 0,
            ]);
        }

        return $subscriber->refresh();
    }

    public function update(Subscriber $subscriber)
    {
        return $subscriber->update([
            'email_verified_at' => date('Y-m-d H:i:s'),
            'is_active' => 1,
            'token' => null
        ]);
    }

    public function find(string $token, string $email)
    {
        return Subscriber::query()
            ->where('token', '=', $token)
            ->where('email', '=', $email)
            ->first();
    }

    public function delete(int $userId)
    {
        return Subscriber::query()
            ->where('user_id', '=', $userId)
            ->delete();
    }
}
