@extends('layouts.admin')

@section('title', 'Товары')

@section('content')
    <div class="content-header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h5 class="m-0">Товары</h5>
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
                            <a href="{{ route('admin.products.create') }}"
                               class="btn btn-primary btn-sm" title="@lang('messages.add')">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                                @lang('messages.add')
                            </a>

                            <button type="button" class="btn btn-secondary" data-toggle="modal"
                                    data-target="#secondary">
                                <i class="fas fa-file-import"></i>
                                Импорт товары
                            </button>

                            <div class="modal fade text-left" id="secondary" tabindex="-1"
                                 role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                     role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-secondary">
                                            <h6 class="modal-title white">Импортировать товары</h6>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('admin.products.import') }}"
                                                  method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div
                                                        class="custom-file required @error('document') is-invalid @enderror">
                                                    <label for="document" class="control-label custom-file-label">Excel
                                                        файл (Макс: 20Мб): </label>
                                                    <input type="file" class="custom-file-input" id="document"
                                                           accept=".xlsx, .xls"
                                                           name="document" required>
                                                    @error('document')
                                                    <span class="error invalid-feedback">{{ $message }} </span>
                                                    @enderror
                                                </div>
                                                <div
                                                        class="buttons d-flex align-items-center justify-content-center mt-3">
                                                    <button type="reset"
                                                            class="btn btn-outline-danger"
                                                            data-dismiss="modal">
                                                        @lang('messages.cancel')
                                                    </button>
                                                    <button type="submit"
                                                            class="btn btn-primary ml-1">
                                                        Импортировать
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{ route('admin.products.importExample') }}"
                                                  method="POST"
                                                  class="w-100 d-flex align-items-center justify-content-center">
                                                @csrf
                                                <button type="submit" class="text-primary">
                                                    Скачать образец
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <button type="button" class="btn btn-secondary" data-toggle="modal"
                                    data-target="#secondary2">
                                <i class="fas fa-file-import"></i>
                                Импорт изображения
                            </button>

                            <div class="modal fade text-left" id="secondary2" tabindex="-1"
                                 role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                     role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-secondary">
                                            <h6 class="modal-title white">Импортировать изображения</h6>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('admin.products.importImages') }}"
                                                  method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div
                                                        class="custom-file required @error('document') is-invalid @enderror">
                                                    <label for="document" class="control-label custom-file-label">
                                                        ZIP файл (Макс: 50Мб): </label>
                                                    <input type="file" class="custom-file-input" id="document"
                                                           accept=".zip"
                                                           name="document" required>
                                                    @error('document')
                                                    <span class="error invalid-feedback">{{ $message }} </span>
                                                    @enderror
                                                </div>
                                                <div
                                                        class="buttons d-flex align-items-center justify-content-center mt-3">
                                                    <button type="reset"
                                                            class="btn btn-outline-danger"
                                                            data-dismiss="modal">
                                                        @lang('messages.cancel')
                                                    </button>
                                                    <button type="submit"
                                                            class="btn btn-primary ml-1">
                                                        Импортировать
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <div class="w-100 d-flex align-items-center justify-content-center">
                                                &nbsp; Для загрузки нескольких изображений одного товара после артикула
                                                ставим
                                                нижный тере и номер изображения.
                                                Например, список изображений: artikul_1.png, artikul_2.png
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <button type="button" class="btn btn-secondary" data-toggle="modal"
                                    data-target="#secondary3">
                                <i class="fas fa-file-import"></i>
                                Импорт инструкции
                            </button>

                            <div class="modal fade text-left" id="secondary3" tabindex="-1"
                                 role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                     role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-secondary">
                                            <h6 class="modal-title white">Импортировать инструкции</h6>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('admin.products.importDocuments') }}"
                                                  method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div
                                                        class="custom-file required @error('document') is-invalid @enderror">
                                                    <label for="document" class="control-label custom-file-label">
                                                        ZIP файл (Макс: 50Мб): </label>
                                                    <input type="file" class="custom-file-input" id="document2"
                                                           accept=".zip"
                                                           name="document" required>
                                                    @error('document')
                                                    <span class="error invalid-feedback">{{ $message }} </span>
                                                    @enderror
                                                </div>
                                                <div
                                                        class="buttons d-flex align-items-center justify-content-center mt-3">
                                                    <button type="reset"
                                                            class="btn btn-outline-danger"
                                                            data-dismiss="modal">
                                                        @lang('messages.cancel')
                                                    </button>
                                                    <button type="submit"
                                                            class="btn btn-primary ml-1">
                                                        Импортировать
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <div class="w-100 d-flex align-items-center justify-content-center">
                                                &nbsp; Для загрузки нескольких инструкции одного товара артикула ставим
                                                Например, список: artikul.pdf, artikul2.pdf
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <form action="{{ route('admin.products.export') }}"
                                  method="POST" class="mr-auto">
                                @csrf
                                <button type="submit" class="btn btn-secondary">
                                    <i class="fas fa-file-download"></i>
                                    Экспорт Excel
                                </button>
                            </form>

                            <a href="{{ route('admin.products.create') }}"
                               class="btn btn-success btn-sm" title="@lang('messages.add')">
                                <i class="fa fa-minus-square" aria-hidden="true"></i>
                                Акций
                            </a>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-outline-primary" data-toggle="modal"
                                    data-target="#primary4">
                                <i class="fas fa-filter"></i>
                                Фильтр
                            </button>
                            <div class="modal fade text-left" id="primary4" tabindex="-1"
                                 role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                     role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary">
                                            <h6 class="modal-title white">Фильтр</h6>
                                        </div>
                                        <div class="modal-body">
                                            <form method="GET"
                                                  action="{{ route('admin.products.index') }}">
                                                <div class="form-group">
                                                    <select name="category_id" id="category_id"
                                                            class="form-control select2" style="width: 100%;">
                                                        <option value="">Выберите категорий ...</option>
                                                        @forelse($categories as $category)
                                                            <option
                                                                    {{ $category->id == request('category_id') ? 'selected' : '' }}
                                                                    value="{{ $category->id }}">
                                                                {{ $category->titleTranslate?->ru }}
                                                            </option>
                                                        @empty
                                                            <option selected disabled>Категорий не найдены</option>
                                                        @endforelse
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="search"
                                                           placeholder="@lang('messages.search')..."
                                                           value="{{ request('search') ?? '' }}">
                                                </div>

                                                <div class="form-group text-center mt-2 mb-0">
                                                    <button class="btn btn-outline-danger" type="button"
                                                            onclick="window.location.href = '{{ route('admin.products.index') }}'">
                                                        Сбросить
                                                    </button>
                                                    <button class="btn btn-primary" type="submit">
                                                        Поиск товара
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="info-box info-card flex-column shadow-none">

                        <div class="table-responsive" id="for_sort">
                            <table class="table table-hover">
                                <thead class="thead">
                                <tr>
                                    <th>#ID</th>
                                    <th>@lang('validation.attributes.image')</th>
                                    <th>Название</th>
                                    <th>Код товара</th>
                                    <th>Видимость</th>
                                    {{-- <th>Новинки</th>--}}
                                    <th>Статус на складе</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($products as $product)
                                    <tr>
                                        <td>{{ $product->id }}</td>
                                        <td>
                                            <img src="{{ $product->image_url }}" class="rounded product-index-image">
                                        </td>
                                        <td style="white-space: normal">{{ $product->titleTranslate?->ru }}</td>
                                        <td>{{ $product->vendor_code }}</td>
                                        <td>
                                            <label class="checkbox-label">
                                                <input id="checkbox" class="checkbox cb cb1 update_is_active"
                                                       type="checkbox" name="is_active" value="1"
                                                       data-id="{{ $product->id }}"
                                                        {{ $product->is_active == 1 ? 'checked' : '' }} />
                                                <i></i>
                                            </label>
                                        </td>
                                        {{--   <td>--}}
                                        {{--       <label class="checkbox-label">--}}
                                        {{--           <input id="checkbox2" class="checkbox cb cb1 update_is_new"--}}
                                        {{--                  type="checkbox" name="is_new" value="1"--}}
                                        {{--                  data-id="{{ $product->id }}"--}}
                                        {{--               {{ $product->is_new == 1 ? 'checked' : '' }} />--}}
                                        {{--           <i></i>--}}
                                        {{--       </label>--}}
                                        {{--   </td>--}}
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
                                        <td>
                                            <div class="card-tools">
                                                <a href="{{ route('admin.products.editSeo', ['product' => $product]) }}"
                                                   title="@lang('messages.seo')"
                                                   class="btn btn-info btn-sm">
                                                    @lang('messages.seo')
                                                </a>
                                                <a href="{{ route('admin.productImages.index', ['product' => $product]) }}"
                                                   class="btn btn-primary btn-sm">
                                                    <i class="fa fa-images"></i>
                                                </a>
{{--                                                <a href="{{ route('admin.products.show', ['product' => $product]) }}"--}}
{{--                                                   title="@lang('messages.view')" class="btn btn-primary btn-icon">--}}
{{--                                                    <i class="fa fa-eye" aria-hidden="true"></i>--}}
{{--                                                </a>--}}
                                                <a href="{{ route('admin.products.edit', ['product' => $product]) }}"
                                                   title="@lang('messages.edit')"
                                                   class="btn btn-primary btn-icon">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <form method="POST" class="d-inline"
                                                      action="{{ route('admin.products.destroy', ['product' => $product]) }}">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                            title="@lang('messages.delete')"
                                                            onclick="return confirm('@lang('messages.confirm_deletion')')">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td align="center" class="text-danger p-2" colspan="7">
                                            Товары не найдены
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>

                            <div class="pagination-wrapper">
                                {!! $products->appends(['search' => request('search')])->render() !!}
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
    <script>
        $('.update_is_active').click(function (e) {
            let dataId = $(this).attr('data-id')
            const _token = $('meta[name="csrf-token"]').attr('content');

            if ($(this).prop('checked')) {
                $.ajax({
                    method: "POST",
                    url: `/admin/products/${dataId}/updateIsActive`,
                    data: {
                        _token: _token,
                        is_active: 1,
                        data_id: dataId,
                    },
                    success: (response) => {
                        console.log(response.status)
                    }
                })
            } else {
                $.ajax({
                    method: "POST",
                    url: `/admin/products/${dataId}/updateIsActive`,
                    data: {
                        _token: _token,
                        is_active: 0,
                        data_id: dataId,
                    },
                    success: (response) => {
                        console.log(response.status)
                    }
                })
            }
        });

        // $('.update_is_new').click(function (e) {
        //     let dataId = $(this).attr('data-id')
        //     const _token = $('meta[name="csrf-token"]').attr('content');
        //
        //     if ($(this).prop('checked')) {
        //         $.ajax({
        //             method: "POST",
        //             url: `/admin/products/${dataId}/updateIsNew`,
        //             data: {
        //                 _token: _token,
        //                 is_new: 1,
        //                 data_id: dataId,
        //             },
        //             success: (response) => {
        //                 console.log(response.status)
        //             }
        //         })
        //     } else {
        //         $.ajax({
        //             method: "POST",
        //             url: `/admin/products/${dataId}/updateIsNew`,
        //             data: {
        //                 _token: _token,
        //                 is_new: 0,
        //                 data_id: dataId,
        //             },
        //             success: (response) => {
        //                 console.log(response.status)
        //             }
        //         })
        //     }
        // });
    </script>
@endpush
