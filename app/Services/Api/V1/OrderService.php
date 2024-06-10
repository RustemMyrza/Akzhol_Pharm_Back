<?php

namespace App\Services\Api\V1;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Payment;
use App\Models\Product;

class OrderService
{
    public function create(array $validated, int $userId)
    {
        $order = Order::query()
            ->create([
                "user_type" => $validated['user_type'],
                "delivery_type" => $validated['delivery_type'],
                "user_id" => $userId,

                "first_name" => $validated['first_name'] ?? null,
                "last_name" => $validated['last_name'] ?? null,
                "email" => $validated['email'] ?? null,
                "phone" => $validated['phone'] ?? null,
                "address" => $validated['address'] ?? null,
                "message" => $validated['message'] ?? null,
                "payment_method" => $validated['payment_method'] ?? 0,

                "organization_name" => $validated['organization_name'] ?? null,
                "organization_bin" => $validated['organization_bin'] ?? null,
                "organization_email" => $validated['organization_email'] ?? null,
                "organization_phone" => $validated['organization_phone'] ?? null,
                "organization_legal_address" => $validated['organization_legal_address'] ?? null,
                "organization_current_address" => $validated['organization_current_address'] ?? null,
            ]);

        $amount = 0;
        foreach ($validated['orderProducts'] as $orderProduct) {
            $product = Product::query()->with('titleTranslate')->where('id', '=', $orderProduct['id'])->first();
            $totalPrice = discountPriceCalculate($product->price, $product->discount) * $orderProduct['quantity'];

            if ($product->stock_quantity > $orderProduct['quantity']) {
                $product->update(['stock_quantity' => $product->stock_quantity - $orderProduct['quantity']]);
            } else {
                $product->update(['stock_quantity' => 0]);
            }

            OrderProduct::query()
                ->create([
                    'order_id' => $order->id,
                    'product_id' => $orderProduct['id'],
                    'product_name' => $product->titleTranslate?->ru,
                    'vendor_code' => $product->vendor_code,
                    'price' => $product->price,
                    'quantity' => $orderProduct['quantity'],
                    'discount' => $product->discount,
                    'total_price' => discountPriceCalculate($product->price, $product->discount) * $orderProduct['quantity'],
                ]);
            $amount = $amount + $totalPrice;
        }

        return [
            'order_id' => $order->id,
            'user_id' => $userId,
            'amount' => $amount
        ];
    }

    public function getOrderProductsByStatus(\Illuminate\Http\Request $request, array $statuses)
    {
        return OrderProduct::query()
            ->with(['product', 'order'])
            ->whereHas('order', function ($query) use ($request, $statuses) {
                return $query->where('user_id', '=', $request->user()->id)
                    ->whereIn('status', $statuses);
            })
            ->paginate(15);
    }

    public function update(Payment $payment)
    {
        return $payment->order?->update(['payment_status' => $payment->status]);
    }
}
