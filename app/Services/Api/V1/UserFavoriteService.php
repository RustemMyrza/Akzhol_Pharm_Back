<?php

namespace App\Services\Api\V1;

use App\Models\Product;
use App\Models\UserFavorite;

class UserFavoriteService
{
    public function create(int $userId, array $validated)
    {
        return UserFavorite::query()
            ->create([
                'user_id' => $userId,
                'product_id' => $validated['product_id']
            ]);
    }

    public function getUserFavorites(int $userId)
    {
        $productIds = UserFavorite::query()->where('user_id', '=', $userId)->pluck('product_id')->toArray();
        return Product::query()
            ->whereIn('id', $productIds)
            ->paginate();
    }

    public function getUserFavorite(int $userId, array $validated)
    {
        return UserFavorite::query()
            ->where('user_id', '=', $userId)
            ->where('product_id', '=', $validated['product_id'])
            ->first();
    }

    public function delete($userPostFavorite)
    {
       return $userPostFavorite->delete();
    }
}
