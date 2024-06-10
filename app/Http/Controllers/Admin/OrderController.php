<?php

namespace App\Http\Controllers\Admin;

use App\Enum\UserTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Order\ExportOrderRequest;
use App\Http\Requests\Admin\Order\StoreOrderRequest;
use App\Http\Requests\Admin\Order\UpdateOrderRequest;
use App\Models\Order;
use App\Services\Admin\Order\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Rap2hpoutre\FastExcel\FastExcel;

class OrderController extends Controller
{
    public OrderService $service;

    public function __construct(OrderService $orderService)
    {
        $this->service = $orderService;
    }

    public function index(Request $request)
    {
        try {
            return view('admin.orders.index', $this->service->getOrders($request));
        } catch (\Exception $exception) {
            return backPageError($exception->getMessage());
        }
    }

    public function create()
    {
        try {
            return view('admin.orders.create', $this->service->getDefaultData());
        } catch (\Exception $exception) {
            return backPageError($exception->getMessage());
        }
    }

    public function store(StoreOrderRequest $request)
    {
        try {
            $this->service->create($request->validated());
            return redirectPage('admin.orders.index', trans('messages.success_created'));
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }

    public function show(Order $order)
    {
        try {
            return view('admin.orders.show', ['order' => $order->load('user', 'orderProducts')]);
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }

    public function edit(Order $order)
    {
        $data = $this->service->getDefaultData();
        $data['order'] = $order;
        return view('admin.orders.edit', $data);
    }

    public function update(UpdateOrderRequest $request, Order $order)
    {
        try {
            $this->service->update($order, $request->validated());
            return redirectPage('admin.orders.index', trans('messages.success_updated'));
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }

    public function destroy(Order $order)
    {
        try {
            return DB::transaction(function () use ($order) {
                $this->service->delete($order);
                return redirectPage('admin.orders.index', trans('messages.success_deleted'));
            });
        } catch (\Exception $exception) {
            return back()->withErrors($exception->getMessage());
        }
    }

    public function export(ExportOrderRequest $request)
    {
        try {
            return (new FastExcel($this->service->ordersByUserTypeGenerator($request)))
                ->headerStyle($this->service->headerStyles())
                ->rowsStyle($this->service->rowsStyles())
                ->configureOptionsUsing(function ($writer) use ($request) {
                    if ($request->user_type == UserTypeEnum::INDIVIDUAL) {
                        $writer->setColumnWidth(15, 2, 3, 4, 5, 7, 8);
                        $writer->setColumnWidth(20, 6);
                    } else {
                        $writer->setColumnWidth(15, 2, 3, 5);
                        $writer->setColumnWidth(20, 4, 6, 7, 8, 9);
                    }
                    $writer->setColumnWidth(14, 10);
                    $writer->setColumnWidth(25, 11);
                })
                ->download('Заказы.xlsx');
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }
}
