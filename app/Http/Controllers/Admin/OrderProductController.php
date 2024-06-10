<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OrderProduct\StoreOrderProductRequest;
use App\Http\Requests\Admin\OrderProduct\UpdateOrderProductRequest;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Services\Admin\OrderProduct\OrderProductService;

class OrderProductController extends Controller
{
    public OrderProductService $service;

    public function __construct(OrderProductService $orderProductService)
    {
        $this->service = $orderProductService;
    }

    public function index(Order $order)
    {
        return view('admin.orderProducts.index', $this->service->getOrderProducts($order));
    }

    public function store(Order $order, StoreOrderProductRequest $request)
    {
        try {
            $this->service->create($order, $request->validated());
            return backPage(trans('messages.success_created'));
        } catch (\Exception $exception) {
            return back()->withErrors($exception->getMessage());
        }
    }

    public function update(Order $order, OrderProduct $orderProduct, UpdateOrderProductRequest $request)
    {
        try {
            $this->service->update($order, $orderProduct, $request->validated());
            return backPage(trans('messages.success_updated'));
        } catch (\Exception $exception) {
            return back()->withErrors($exception->getMessage());
        }
    }

    public function destroy(Order $order, OrderProduct $orderProduct)
    {
        try {
            $this->service->delete($orderProduct);
            return backPage(trans('messages.success_deleted'));
        } catch (\Exception $exception) {
            return back()->withErrors($exception->getMessage());
        }
    }
}
