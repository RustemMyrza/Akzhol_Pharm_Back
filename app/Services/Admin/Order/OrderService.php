<?php

namespace App\Services\Admin\Order;

use App\Enum\DeliveryTypeEnum;
use App\Enum\OrderStatusEnum;
use App\Enum\PaymentMethodEnum;
use App\Enum\UserTypeEnum;
use App\Http\Requests\Admin\Order\ExportOrderRequest;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\User;
use App\Services\Admin\Service;
use Illuminate\Http\Request;
use OpenSpout\Common\Entity\Style\Style;
use OpenSpout\Common\Exception\InvalidArgumentException;

class OrderService extends Service
{
    public function getOrders(Request $request): array
    {
        return [
            'statuses' => OrderStatusEnum::statuses(),
            'userTypes' => UserTypeEnum::types(),
            'orders' => Order::query()
                ->when($request->filled('search'), function ($query) use ($request) {
                    $keywords = explode(' ', $request->input('search'));

                    $query->where(function ($subQuery) use ($keywords) {
                        foreach ($keywords as $keyword) {
                            $subQuery->where('id', 'like', "%$keyword%")
                                ->orWhere('first_name', 'like', "%$keyword%")
                                ->orWhere('last_name', 'like', "%$keyword%")
                                ->orWhere('phone', 'like', "%$keyword%")
                                ->orWhere('email', 'like', "%$keyword%")
                                ->orWhere('address', 'like', "%$keyword%")
                                ->orWhere('message', 'like', "%$keyword%")
                                ->orWhere('organization_name', 'like', "%$keyword%")
                                ->orWhere('organization_bin', 'like', "%$keyword%")
                                ->orWhere('organization_email', 'like', "%$keyword%")
                                ->orWhere('organization_phone', 'like', "%$keyword%")
                                ->orWhere('organization_legal_address', 'like', "%$keyword%");
                        }
                    });
                })
                ->when($request->filled('status'), function ($query) use ($request) {
                    $query->where('status', '=', $request->input('status'));
                })
                ->when($request->filled('user_type'), function ($query) use ($request) {
                    $query->where('user_type', '=', $request->input('user_type'));
                })
                ->with('orderProducts')
                ->withCount('orderProducts')
                ->latest()
                ->paginate(20)
        ];
    }

    public function getDefaultData()
    {
        return [
            'statuses' => OrderStatusEnum::statuses(),
            'userTypes' => UserTypeEnum::types(),
            'deliveryTypes' => DeliveryTypeEnum::types(),
            'paymentMethods' => PaymentMethodEnum::methods(),
            'users' => cache()->remember(authHasRole() ? 'forDeveloperUsers' : 'forAdminUsers', User::CACHE_TIME, function () {
                return User::query()
                    ->with('roles')
                    ->whereHas("roles", function ($query) {
                        $query->whereIn("name", User::getRolesForUser());
                    })
                    ->get(['id', 'first_name', 'last_name', 'email']);
            })
        ];
    }

    public function create(array $data)
    {
        return Order::query()
            ->create([
                "user_type" => $data['user_type'],
                "delivery_type" => $data['delivery_type'],
                "user_id" => $data['user_id'],

                "first_name" => $data['first_name'] ?? null,
                "last_name" => $data['last_name'] ?? null,
                "email" => $data['email'] ?? null,
                "phone" => $data['phone'] ?? null,
                "address" => $data['address'] ?? null,
                "message" => $data['message'] ?? null,
                "payment_method" => $data['payment_method'] ?? null,

                "organization_name" => $data['organization_name'] ?? null,
                "organization_bin" => $data['organization_bin'] ?? null,
                "organization_email" => $data['organization_email'] ?? null,
                "organization_phone" => $data['organization_phone'] ?? null,
                "organization_legal_address" => $data['organization_legal_address'] ?? null,
                "organization_current_address" => $data['organization_current_address'] ?? null,

                "status" => $data['status'],
            ]);
    }

    public function update(Order $order, array $data)
    {
        $order->user_type = $data['user_type'];
        $order->delivery_type = $data['delivery_type'];
        $order->user_id = $data['user_id'];

        $order->first_name = $data['first_name'] ?? null;
        $order->last_name = $data['last_name'] ?? null;
        $order->email = $data['email'] ?? null;
        $order->phone = $data['phone'] ?? null;
        $order->address = $data['address'] ?? null;
        $order->message = $data['message'] ?? null;
        $order->payment_method = $data['payment_method'] ?? null;

        $order->organization_name = $data['organization_name'] ?? null;
        $order->organization_bin = $data['organization_bin'] ?? null;
        $order->organization_email = $data['organization_email'] ?? null;
        $order->organization_phone = $data['organization_phone'] ?? null;
        $order->organization_legal_address = $data['organization_legal_address'] ?? null;
        $order->organization_current_address = $data['organization_current_address'] ?? null;

        $order->status = $data['status'];
        return $order->save();
    }

    public function delete(Order $order)
    {
        if (count($order->orderProducts)) {
            foreach ($order->orderProducts as $orderProduct) {
                $orderProduct->delete();
            }
        }
        return $order->delete();
    }

    public function ordersByUserTypeGenerator(ExportOrderRequest $request)
    {
        $orderProducts = OrderProduct::query()
            ->whereHas('order', function ($query) use ($request) {
                $query
                    ->when($request->filled('status'), function ($query) use ($request) {
                        $query->where('status', '=', $request->input('status'));
                    })
                    ->when($request->filled('from_date'), function ($query) use ($request) {
                        $query->whereDate('created_at', '>=', $request->from_date);
                    })
                    ->when($request->filled('to_date'), function ($query) use ($request) {
                        $query->whereDate('created_at', '<=', $request->to_date);
                    })
                    ->where('user_type', '=', $request->input('user_type'));
            })
            ->with(['order', 'product.titleTranslate'])
            ->get();

        if ($request->user_type == UserTypeEnum::INDIVIDUAL) {
            foreach ($orderProducts as $orderProduct) {
                yield [
                    'ID' => $orderProduct->order->id,
                    'Тип плательщика' => $orderProduct->order->user_type_name,
                    'Доставка' => $orderProduct->order->delivery_type_name,
                    'Имя' => $orderProduct->order->first_name,
                    'Фамилия' => $orderProduct->order->last_name,
                    'Почта' => $orderProduct->order->email,
                    'Телефон' => $orderProduct->order->phone ?? '-',
                    'Адресс' => $orderProduct->order->address ?? '-',
                    'Комментарий к заказу' => $orderProduct->order->message ?? '-',
                    'Дата' => $orderProduct->order->created_at_format,
                    'Товар' => $orderProduct->product_name,
                    'Артикул' => $orderProduct->vendor_code,
                    'Цена' => $orderProduct->price,
                    'Количество' => $orderProduct->quantity,
                    'Скидка' => $orderProduct->discount,
                    'Общая цена' => $orderProduct->total_price
                ];
            }
        } else {
            foreach ($orderProducts as $orderProduct) {
                yield [
                    'ID' => $orderProduct->order->id,
                    'Тип плательщика' => $orderProduct->order->user_type_name,
                    'Доставка' => $orderProduct->order->delivery_type_name,
                    'Наименование организации' => $orderProduct->order->organization_name,
                    'БИН/ИИН' => $orderProduct->order->organization_bin,
                    'Почта' => $orderProduct->order->organization_email,
                    'Телефон' => $orderProduct->order->organization_phone,
                    'Юридический адресс' => $orderProduct->order->organization_legal_address,
                    'Фактический адресс' => $orderProduct->order->organization_current_address,
                    'Дата' => $orderProduct->order->created_at_format,
                    'Товар' => $orderProduct->product_name,
                    'Артикул' => $orderProduct->vendor_code,
                    'Цена' => $orderProduct->price,
                    'Количество' => $orderProduct->quantity,
                    'Скидка' => $orderProduct->discount,
                    'Общая цена' => $orderProduct->total_price
                ];
            }
        }

    }

    /**
     * @throws InvalidArgumentException
     */
    public function headerStyles()
    {
        return (new Style())
            ->setFontSize(11)
            ->setCellAlignment('left')
            ->setShouldWrapText(false)
            ->setFontBold();
    }

    /**
     * @throws InvalidArgumentException
     */
    public function rowsStyles()
    {
        return (new Style())
            ->setFontSize(11)
            ->setCellAlignment('left')
            ->setShouldWrapText(false);
    }
}
