@extends('layouts.admin')

@section('title', 'Товары')

@section('content')
    <div class="content-header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h5 class="m-0">Список товары</h5>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container">

            <div class="row">
                @include('admin._components.alert')

                <div class="col-12">
                    <div class="card-tools flex-wrap justify-content-between">
                        <div class="card-tools">
                            <a class="btn btn-warning mb-3" href="{{ route('admin.orders.index') }}"
                               title="@lang('messages.back')">
                                <i class="fa fa-arrow-left" aria-hidden="true"></i>
                                @lang('messages.back')
                            </a>
                        </div>
                    </div>

                    <div class="info-box flex-column shadow-none">
                        <form method="POST" action="{{ route('admin.orderProducts.store', $order) }}">
                            @csrf
                            @method('POST')
                            @includeIf('admin.orderProducts._form')
                        </form>
                    </div>

                    <h6 class="mb-3 mt-3">Товары ({{ count($orderProducts) }})</h6>

                    <div class="info-box flex-column shadow-none">
                        @forelse($orderProducts as $orderProduct)
                            <div class="row">
                                <div class="col-12 col-lg-11">
                                    <form method="POST"
                                          action="{{ route('admin.orderProducts.update', ['order' => $order, 'orderProduct' => $orderProduct]) }}">
                                        @csrf
                                        @method('PATCH')
                                        @includeIf('admin.orderProducts._form', ['formMode' => 'edit', 'orderProduct' => $orderProduct])
                                    </form>
                                </div>
                                <div class="col-12 col-lg-1">
                                    <form method="POST"
                                          action="{{ route('admin.orderProducts.destroy', ['order' => $order, 'orderProduct' => $orderProduct]) }}">
                                        @csrf
                                        @method('DELETE')
                                        <div class="row">
                                            <div class="col-12 col-md-6 col-lg-12">
                                                <div class="form-group ">
                                                    <label for="quantity" class="control-label"> &nbsp; </label>
                                                    <button type="submit" class="btn btn-danger form-control"
                                                            onclick="return confirm('@lang('messages.confirm_deletion')')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="alert alert-danger alert-dismissible border-0">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <p class="m-0"><i class="icon fas fa-ban"></i>Товары не найдены</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection

@push('scripts')
    @includeIf('admin._components.select2Scripts')
@endpush
