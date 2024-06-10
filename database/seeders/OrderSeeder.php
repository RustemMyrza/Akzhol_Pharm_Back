<?php

namespace Database\Seeders;

use App\Enum\UserTypeEnum;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Payment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * php artisan db:seed --class=OrderSeeder
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 100; $i++) {
            DB::transaction(function () {
                $order = Order::factory()->create();

                $amount = 0;
                $description = '';
                for ($j = 0; $j < 2; $j++) {
                    $orderProduct = OrderProduct::factory()
                        ->create([
                            'order_id' => $order->id,
                            'status' => $order->status
                        ]);

                    $amount = $amount + $orderProduct->total_price;
                    $description = $description . ' ' . $orderProduct->product_name;
                }

                if ($order->user_type == UserTypeEnum::ENTITY) {
                    Payment::factory()
                        ->create([
                            'order_id' => $order->id,
                            'user_id' => $order->user_id,
                            'amount' => $amount,
                            'description' => $description,
                        ]);
                }

                return 1;
            });
        }
    }
}
