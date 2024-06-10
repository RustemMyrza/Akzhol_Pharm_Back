<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderProduct>
 */
class OrderProductFactory extends Factory
{
    protected int $index = 1;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $currentIndex = $this->index;
        $this->index++;

        $product = Product::query()->with('titleTranslate')->find($currentIndex);
        $quantity = rand(1, 5);
        $discountPrice = discountPriceCalculate($product->price, $product->discount);

        return [
            'product_id' => $product->id,
            'product_name' => $product->titleTranslate?->ru,
            'vendor_code' => $product->vendor_code,
            'price' => $product->price,
            'quantity' => $quantity,
            'discount' => $product->discount,
            'total_price' => $discountPrice * $quantity,
        ];
    }
}
