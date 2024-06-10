@extends('layouts.admin')

@section('title', trans('messages.main'))

@section('content')
    <div class="content-header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h5 class="m-0">@lang('messages.main')</h5>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container">
            <div class="row">
                @include('admin._components.alert')
                @includeIf('admin._components.smallBox', ['count' => $usersCount, 'link' => route('admin.users.index') ,'text' => trans('messages.users')])
                @includeIf('admin._components.smallBox', ['count' => $ordersCount, 'link' => route('admin.orders.index') ,'text' => 'Заказы'])
                @includeIf('admin._components.smallBox', ['count' => $categoriesCount, 'link' => route('admin.categories.index') ,'text' => 'Каталог'])
                @includeIf('admin._components.smallBox', ['count' => $citiesCount, 'link' => route('admin.cities.index') ,'text' => 'Города'])
                @includeIf('admin._components.smallBox', ['count' => $productsCount, 'link' => route('admin.products.index') ,'text' => 'Товары'])
            </div>
        </div>
    </section>
@endsection
