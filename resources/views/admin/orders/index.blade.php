@extends('layouts.admin')

@section('title', 'Заказы')

@section('content')
    <div class="content-header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h5 class="m-0">Заказы ({{ $orders->total() }})</h5>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container">

            <div class="row">
                @include('admin._components.alert')

                <div class="col-12">
                    <div class="card-tools flex-wrap justify-content-between mb-2 mb-md-3">
                        <div class="card-tools flex-wrap">
                            <a href="{{ route('admin.orders.create') }}"
                               class="btn btn-primary"
                               title="@lang('messages.add')">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                                @lang('messages.add')
                            </a>

                            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#primary">
                                <i class="fas fa-file-download"></i>
                                @lang('messages.excel_upload')
                            </button>

                            <div class="modal fade text-left" id="primary" tabindex="-1"
                                 role="dialog"
                                 aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                     role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-secondary">
                                            <h6 class="modal-title white">@lang('messages.excel_upload')</h6>
                                        </div>
                                        <form action="{{ route('admin.orders.export') }}"
                                              method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="form-group mb-2">
                                                    <label for="user_type" class="control-label">
                                                        Тип плательщика:
                                                    </label>
                                                    <select name="user_type" class="form-control select2"
                                                            style="width: 100%;">
                                                        @forelse($userTypes as $userTypeIndex => $userType)
                                                            <option value="{{ $userTypeIndex }}"
                                                                    @if(!is_null(request('user_type')) && old('user_type') == $userTypeIndex) selected @endif>
                                                                {{ $userType }}
                                                            </option>
                                                        @empty
                                                            <option selected disabled>
                                                                Тип плательщика не найдены
                                                            </option>
                                                        @endforelse
                                                    </select>
                                                </div>

                                                <div class="form-group mb-2">
                                                    <label for="status" class="control-label">
                                                        @lang('messages.by_status'):
                                                    </label>
                                                    <select name="status" class="form-control select2"
                                                            style="width: 100%;">
                                                        <option value="">@lang('messages.not_selected')</option>
                                                        @forelse($statuses as $statusIndex => $status)
                                                            <option value="{{ $statusIndex }}"
                                                                    @if(!is_null(request('status')) && old('status') == $statusIndex) selected @endif>
                                                                {{ $status }}
                                                            </option>
                                                        @empty
                                                            <option selected disabled>
                                                                @lang('messages.statuses_not_found')
                                                            </option>
                                                        @endforelse
                                                    </select>
                                                </div>

                                                <div class="form-row mb-2">
                                                    <div class="form-group col-md-6">
                                                        <label for="from_date" class="control-label">От: </label>
                                                        <input type="date" class="form-control" id="from_date"
                                                               name="from_date"
                                                               value="{{ old('from_date') ?? '' }}">
                                                    </div>

                                                    <div class="form-group col-md-6">
                                                        <label for="to_date" class="control-label">До: </label>
                                                        <input type="date" class="form-control" id="to_date"
                                                               name="to_date"
                                                               value="{{ old('to_date') ?? '' }}">
                                                    </div>
                                                </div>

                                                <div class="buttons d-flex align-items-center justify-content-center">
                                                    <button type="reset"
                                                            class="btn btn-outline-danger"
                                                            data-dismiss="modal">
                                                        @lang('messages.cancel')
                                                    </button>
                                                    <button type="submit"
                                                            class="btn btn-primary ml-1">
                                                        Выгрузить
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-wrap justify-content-end">
                            <form method="GET" class="search-form form-inline"
                                  action="{{ route('admin.orders.index') }}">
                                <div class="form-group mb-2 mb-lg-0 mr-lg-2">
                                    <select name="user_type" class="form-control select2"
                                            onchange="this.form.submit()">
                                        <option value="">Тип плательщика ...</option>
                                        @forelse($userTypes as $userTypeIndex => $userType)
                                            <option
                                                {{ !is_null(request('user_type')) && $userTypeIndex == request('user_type') ? 'selected' : '' }}
                                                value="{{ $userTypeIndex }}" class="text-bold">
                                                {{ $userType }}
                                            </option>
                                        @empty
                                            <option selected disabled>Тип плательщика не найдены</option>
                                        @endforelse
                                    </select>
                                </div>
                                <div class="form-group mb-2 mb-lg-0 mr-lg-2">
                                    <select name="status" class="form-control select2"
                                            onchange="this.form.submit()">
                                        <option value="">Статус ...</option>
                                        @forelse($statuses as $statusIndex => $status)
                                            <option
                                                {{ !is_null(request('status')) && $statusIndex == request('status') ? 'selected' : '' }}
                                                value="{{ $statusIndex }}" class="text-bold">
                                                {{ $status }}
                                            </option>
                                        @empty
                                            <option selected disabled>Статусы не найдены</option>
                                        @endforelse
                                    </select>
                                </div>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="search"
                                           placeholder="@lang('messages.search')..."
                                           value="{{ request('search') ?? '' }}">
                                    <span class="input-group-append">
                                <button class="btn btn-secondary" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="info-box info-card flex-column shadow-none">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="thead">
                                <tr>
                                    <th>#</th>
                                    <th>Пользователь / Организация</th>
                                    <th>Тип плательщика</th>
                                    <th>Сумма</th>
                                    <th>@lang('validation.attributes.time')</th>
                                    <th>@lang('validation.attributes.status')</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse ($orders as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>
                                            @if($order->user_type == \App\Enum\UserTypeEnum::INDIVIDUAL)
                                                {{ $order->full_name }} <br>
                                                {{ $order->phone }}
                                            @else
                                                {{ $order->organization_name }} <br>
                                                {{ $order->organization_phone }}
                                            @endif
                                        </td>
                                        <td>{{ $order->user_type_name }}</td>
                                        <td>{{ count($order->orderProducts) ? priceFormat($order->orderProducts?->sum('total_price')) : priceFormat(0) }}</td>
                                        <td>{{ $order->created_at_format }}</td>
                                        <td>
                                            {!! \App\Enum\OrderStatusEnum::getStatusHtml($order->status) !!}
                                        </td>
                                        <td>
                                            <div class="card-tools">
                                                <a href="{{ route('admin.orderProducts.index', ['order' => $order]) }}"
                                                   title="@lang('messages.edit')" class="btn btn-outline-primary btn-icon">
                                                    <i class="nav-icon fas fa-shopping-cart"></i>
                                                    Товары ({{ $order->order_products_count }})
                                                </a>

                                                <a href="{{ route('admin.orders.show',['order' => $order]) }}"
                                                   title="@lang('messages.view')" class="btn btn-primary btn-icon">
                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                </a>

                                                <a href="{{ route('admin.orders.edit', ['order' => $order]) }}"
                                                   title="@lang('messages.edit')" class="btn btn-primary btn-icon">
                                                    <i class="fa fa-edit" aria-hidden="true"></i>
                                                </a>

                                                <form method="POST"
                                                      action="{{ route('admin.orders.destroy', ['order' => $order]) }}"
                                                      style="display:inline">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger"
                                                            title="@lang('messages.delete')"
                                                            onclick="return confirm('@lang('messages.confirm_deletion')')">
                                                        <i class="fas fa-trash" aria-hidden="true"></i>
                                                        Удалить
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <td align="center" class="text-danger p-2" colspan="9">
                                        Заказы не найдены
                                    </td>
                                @endforelse
                                </tbody>
                            </table>
                            <div class="pagination-wrapper">
                                {!! $orders->appends(['search' => request('search')])->render() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection

@push('scripts')
    @includeIf('admin._components.select2Scripts')
@endpush
