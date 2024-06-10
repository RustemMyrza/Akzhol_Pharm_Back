@extends('layouts.admin')

@section('title', 'Заказ #' . $order->id)

@section('content')
    <div class="content-header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h5 class="m-0">Заказ #{{ $order->id }}</h5>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card-tools mb-3">
                        <a href="{{ route('admin.orders.index') }}" title="@lang('messages.back')"
                           class="btn btn-warning ">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i>
                            @lang('messages.back')
                        </a>
                        <a class="btn btn-primary "
                           href="{{ route('admin.orders.edit',['order' => $order]) }}"
                           title="@lang('messages.edit')">
                            <i class="fa fa-edit" aria-hidden="true"></i>
                            @lang('messages.edit')
                        </a>
                        <form method="POST"
                              action="{{ route('admin.orders.destroy', ['order' => $order]) }}"
                              class="d-inline">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-danger" title="Удалить "
                                    onclick="return confirm('@lang('messages.confirm_deletion')')">
                                <i class="fas fa-trash" aria-hidden="true"></i>
                                @lang('messages.delete')
                            </button>
                        </form>
                    </div>
                </div>

                @include('admin._components.alert')

                <div class="col-12 col-lg-12">
                    <div class="info-box shadow-none">
                        <table class="table table-show not-styles">
                            <tbody>
                            <tr>
                                <th>ID Заказа</th>
                                <td>{{ $order->id }}</td>
                            </tr>
                            <tr>
                                <th>Тип плательщика</th>
                                <td>{{ $order->user_type_name }}</td>
                            </tr>
                            <tr>
                                <th>Доставка</th>
                                <td>{{ $order->delivery_type_name }} </td>
                            </tr>

                            <tr>
                                <th>Пользователь</th>
                                <td>
                                    @if($order->user)
                                        <div class="d-flex align-items-center">
                                            <img class="user-photo" src="{{ $order->user->photo_url }}" alt="">
                                            <a href="{{ route('admin.users.show', $order->user) }}">{{ $order->user->full_name }} </a>
                                        </div>
                                    @else
                                        <div class="d-flex align-items-center">
                                            <img class="user-photo"
                                                 src="{{ asset('adminlte-assets/dist/img/default-user.png') }}" alt="">
                                            <a href="javascript:void(0)"
                                               title="Пользователь не найдено">{{ $order->full_name }} </a>
                                        </div>
                                    @endif
                                </td>
                            </tr>

                            @if($order->user_type == \App\Enum\UserTypeEnum::INDIVIDUAL)
                                <tr>
                                    <th>Имя</th>
                                    <td>{{ $order->first_name }} </td>
                                </tr>
                                <tr>
                                    <th>Фамилия</th>
                                    <td>{{ $order->last_name }} </td>
                                </tr>
                                <tr>
                                    <th>Почта</th>
                                    <td>{{ $order->email ?? '-' }} </td>
                                </tr>
                                <tr>
                                    <th>Телефон</th>
                                    <td>{{ $order->phone ?? '-' }} </td>
                                </tr>
                                <tr>
                                    <th>Адресс</th>
                                    <td>{{ $order->address ?? '-' }} </td>
                                </tr>
                                <tr>
                                    <th>Комментарий к заказу</th>
                                    <td>{{ $order->message ?? '-' }} </td>
                                </tr>
                                <tr>
                                    <th>Cпособ оплаты</th>
                                    <td>{{ $order->payment_method_name }} </td>
                                </tr>
                            @else
                                <tr>
                                    <th>Наименование организации</th>
                                    <td>
                                        {{ $order->organization_name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>БИН/ИИН</th>
                                    <td>
                                        {{ $order->organization_bin }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Почта</th>
                                    <td>
                                        {{ $order->organization_email }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Телефон</th>
                                    <td>
                                        {{ $order->organization_phone }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Юридический адресс</th>
                                    <td>
                                        {{ $order->organization_legal_address }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Фактический адресс</th>
                                    <td>
                                        {{ $order->organization_current_address }}
                                    </td>
                                </tr>
                            @endif

                            <tr>
                                <th>@lang('validation.attributes.time')</th>
                                <td>
                                    {{ $order->created_at_format }}
                                </td>
                            </tr>

                            <tr>
                                <th>@lang('validation.attributes.status')</th>
                                <td>
                                    {!! \App\Enum\OrderStatusEnum::getStatusHtml($order->status) !!}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <h6 class="mb-3">Товары ({{ count($order->orderProducts) }})</h6>

                    <div class="info-box info-card flex-column shadow-none">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="thead">
                                <tr>
                                    <th>#ID</th>
                                    <th>Товар</th>
                                    <th>Артикул</th>
                                    <th>Цена</th>
                                    <th>Количество</th>
                                    <th>Скидка</th>
                                    <th>Общая цена</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse ($order->orderProducts as $orderProduct)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @if($orderProduct->product)
                                                <div class="d-flex align-items-center">
                                                    <img class="user-photo"
                                                         src="{{ $orderProduct->product->image_url }}" alt="">
                                                    <a href="{{ route('admin.products.show', $orderProduct->product) }}">
                                                        {{ $orderProduct->product_name }}
                                                    </a>
                                                </div>
                                            @else
                                                <div class="d-flex align-items-center">
                                                    <a href="javascript:void(0)" title="Товар не найдено">
                                                        {{ $orderProduct->product_name }}
                                                    </a>
                                                </div>
                                            @endif
                                        </td>
                                        <td>{{ $orderProduct->vendor_code }}</td>
                                        <td>{{ priceFormat($orderProduct->price) }}</td>
                                        <td>{{ $orderProduct->quantity }}</td>
                                        <td>{{ discountFormat($orderProduct->discount) }}</td>
                                        <td>{{ priceFormat($orderProduct->total_price) }}</td>
                                    </tr>
                                    @if($loop->last)
                                        <tr>
                                            <td colspan="6"></td>
                                            <td class="pt-2 pb-2 text-primary">
                                                Сумма:
                                                {{ priceFormat($order->orderProducts->sum('total_price')) }}
                                            </td>
                                        </tr>
                                    @endif
                                @empty
                                    <td align="center" class="text-danger p-2" colspan="9">
                                        Товары не найдены
                                    </td>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
