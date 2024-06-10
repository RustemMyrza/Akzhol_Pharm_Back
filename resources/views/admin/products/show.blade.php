@extends('layouts.admin')

@section('title', 'Товар ' . $product->id)

@section('content')
    <div class="content-header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h5 class="m-0">Товар {{ $product->id }}</h5>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card-tools mb-3">
                        <a href="{{ route('admin.products.index') }}" title="@lang('messages.back')"
                           class="btn btn-warning ">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i>
                            @lang('messages.back')
                        </a>
                        <a class="btn btn-primary "
                           href="{{ route('admin.products.edit',['product' => $product]) }}"
                           title="@lang('messages.edit')">
                            <i class="fa fa-edit" aria-hidden="true"></i>
                            @lang('messages.edit')
                        </a>
                        <form method="POST"
                              action="{{ route('admin.products.destroy', ['product' => $product]) }}"
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
                                <th>ID Товара</th>
                                <td>{{ $product->id }}</td>
                            </tr>
                            <tr>
                                <th>Артикул</th>
                                <td style="white-space: normal">{{ $product->vendor_code }}</td>
                            </tr>
                            <tr>
                                <th>Загаловок</th>
                                <td style="white-space: normal">{{ $product->titleTranslate->ru }}</td>
                            </tr>
                            <tr>
                                <th>Описание</th>
                                <td style="white-space: normal">{{ $product->descriptionTranslate->ru }}</td>
                            </tr>
                            <tr>
                                <th>Инструкция</th>
                                <td style="white-space: normal">{{ $product->instructionTranslate->ru }}</td>
                            </tr>

                            <tr>
                                <th>Цена в розницу, ₸</th>
                                <td>{{ $product->price }}</td>
                            </tr>

                            <tr>
                                <th>Скидка, (0-100%)</th>
                                <td>{{ $product->discount }}</td>
                            </tr>

                            <tr>
                                <th>Цена оптом, ₸</th>
                                <td>{{ $product->bulk_price }}</td>
                            </tr>

                            <tr>
                                <th>Количество на складе</th>
                                <td>{{ $product->stock_quantity }}</td>
                            </tr>

                            <tr>
                                <th>Статус на складе</th>
                                <td>
                                    @if($product->status)
                                        <span class="badge badge-success">
                                            В наличии
                                        </span>
                                    @else
                                        <span class="badge badge-danger">
                                            Нет в наличии
                                        </span>
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <th>Статус товара</th>
                                <td>
                                    @if($product->is_active)
                                        <span class="badge badge-success">
                                            Активный
                                        </span>
                                    @else
                                        <span class="badge badge-danger">
                                            Не активный
                                        </span>
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <th>Категорий</th>
                                <td style="white-space: normal">
                                    {{ $product->category?->titleTranslate?->ru }}
                                </td>
                            </tr>

                            <tr>
                                <th>Подкатегорий</th>
                                <td style="white-space: normal">
                                    {{ $product->subCategory?->titleTranslate?->ru }}
                                </td>
                            </tr>

                            <tr>
                                <th>Фильтр</th>
                                <td style="white-space: normal">
                                    @foreach ($filters as $filter)
                                        @foreach ($filter->filterItems as $filterItem)
                                            @if(!in_array($filterItem->id, $productFilterItems))
                                                {{ $filterItem->titleTranslate?->ru }} |
                                            @endif
                                        @endforeach
                                    @endforeach
                                </td>
                            </tr>

                            <tr>
                                <th>Характеристики товара</th>
                                <td style="white-space: normal">
                                    @foreach ($features as $feature)
                                        @foreach ($feature->featureItems as $featureItem)
                                            @if(!in_array($featureItem->id, $productFeatureItems))
                                                {{ $featureItem->titleTranslate?->ru}} |
                                            @endif
                                        @endforeach
                                    @endforeach
                                </td>
                            </tr>

                            <tr>
                                <th>Очередность товара</th>
                                <td>{{ $product->position }}</td>
                            </tr>

                            <tr>
                                <th>Изображение</th>
                                <td>
                                    <img class="rounded product-edit-image" src="{{ $product->image_url }}" alt="">
                                </td>
                            </tr>

                            <tr>
                                <th>Изображения товара ({{ count($product->productImages) }})</th>
                                <td class="d-flex">
                                    @foreach($product->productImages as $productImage)
                                        <img class="rounded product-edit-image mr-2 mb-2" src="{{ $productImage->image_url }}" alt="">
                                    @endforeach
                                </td>
                            </tr>

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
