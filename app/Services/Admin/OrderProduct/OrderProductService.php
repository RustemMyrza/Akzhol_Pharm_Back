<?php

namespace App\Services\Admin\OrderProduct;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Services\Admin\Service;

class OrderProductService extends Service
{
    public function getOrderProducts(Order $order): array
    {
        $orderProducts = OrderProduct::query()->whereOrderId($order->id)->get();
        return [
            'order' => $order,
            'orderProducts' => $orderProducts,
            'products' => Product::query()->whereNotIn('id', $orderProducts->pluck('product_id')->unique())->with('titleTranslate')->get()
        ];
    }

    public function create(Order $order, array $data)
    {
        $product = Product::query()->with('titleTranslate')->first();
        return OrderProduct::query()
            ->create([
                'order_id' => $order->id,
                'product_id' => $data['product_id'],
                'product_name' => $product->titleTranslate?->ru,
                'vendor_code' => $product->vendor_code,
                'price' => $data['price'],
                'quantity' => $data['quantity'],
                'discount' => $data['discount'],
                'total_price' => $data['total_price'],
                'status' => $order->status,
            ]);
    }

    public function update(Order $order, OrderProduct $orderProduct, array $data)
    {
        $orderProduct->price = $data['price'];
        $orderProduct->quantity = $data['quantity'];
        $orderProduct->discount = $data['discount'];
        $orderProduct->total_price = $data['total_price'];
        $orderProduct->status = $order->status;
        return $orderProduct->save();
    }

    public function delete(OrderProduct $orderProduct)
    {
        return $orderProduct->delete();
    }
}
