<?php

namespace Database\Factories;

use App\Enum\DeliveryTypeEnum;
use App\Enum\OrderStatusEnum;
use App\Enum\PaymentMethodEnum;
use App\Enum\PaymentStatusEnum;
use App\Enum\UserTypeEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::query()->inRandomOrder()->first();
        $userType = array_rand(UserTypeEnum::types());

        $defaultData = [
            'user_id' => $user->id,
            'user_type' => $userType,
            'status' => array_rand(OrderStatusEnum::statuses()),
        ];

        $deliveryType = array_rand(DeliveryTypeEnum::types());

        /* Физ лицо */
        if ($userType == UserTypeEnum::INDIVIDUAL) {
            /* Доставка До адресса */
            if ($deliveryType == DeliveryTypeEnum::TO_ADDRESS) {
                $paymentStatus = array_rand(PaymentStatusEnum::statuses());

                $defaultData = array_merge($defaultData, [
                    'address' => fake()->address,
                    'payment_method' => PaymentMethodEnum::BANK_CARD,
                    'payment_status' => $paymentStatus,
                ]);
            }

            return array_merge($defaultData, [
                'first_name' => $user->first_name,
                'last_name' => fake()->name,
                'phone' => fake()->phoneNumber,
                'email' => fake()->email,
                'message' => fake()->text(100),
                'delivery_type' => $deliveryType
            ]);
        }

        /* Юр.лицо */
        return array_merge($defaultData, [
            'organization_name' => fake()->company,
            'organization_bin' => $this->faker->numberBetween(1000000000, 9999999999),
            'organization_email' => fake()->companyEmail,
            'organization_phone' => fake()->phoneNumber,
            'organization_legal_address' => fake()->address,
            'organization_current_address' => fake()->address,
            'delivery_type' => $deliveryType
        ]);
    }
}
