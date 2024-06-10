<?php

namespace Database\Factories;

use App\Enum\PaymentTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'invoice_id' => invoiceIdGenerate(),
            'payment_type' => PaymentTypeEnum::HALYK,
        ];
    }
}
