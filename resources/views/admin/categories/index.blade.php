@extends('layouts.admin')

@section('title', 'Категорий')

@section('content')
    <div class="content-header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h5 class="m-0">Категорий</h5>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container">
            <div class="row">
                @include('admin._components.alert')

                <div class="col-12">
                    <div class="card-tools mb-2 mb-md-3">
                        <a href="{{ route('admin.categories.create') }}"
                           class="btn btn-primary btn-sm mr-1 mb-2 mb-sm-0" title="@lang('messages.add')">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                            @lang('messages.add')
                        </a>
                    </div>

                    <div class="info-box info-card flex-column shadow-none">
                        <div class="table-responsive" id="for_sort">
                            <table class="table table-hover">
                                <thead class="thead">
                                <tr>
                                    <th>#ID</th>
                                    <th>@lang('validation.attributes.image')</th>
                                    <th>@lang('validation.attributes.title')</th>
                                    <th>Подкатегорий</th>
                                    <th>@lang('validation.attributes.status')</th>
                                    <th>Новинки</th>
                                    <th></th>
                                </tr>
                                </thead>

                                <tbody>
                                @forelse($categories as $category)
                                    <tr>
                                        <td data-original-id="{{ $category->id }}" data-id="{{ $category->id }}">{{ $category->id }}</td>
                                       <td>
                                           <img src="{{ $category->image_url }}" class="rounded category-index-image">
                                       </td>
                                        <td>{{ $category->titleTranslate?->ru }}</td>
                                        <td>
                                            <a href="{{ route('admin.subCategories.index', ['category' => $category]) }}"
                                                class="default-link">
                                                Список подкатегорий ({{ $category->sub_categories_count }})
                                            </a>
                                        </td>
                                        <td>
                                            <label class="checkbox-label">
                                                <input id="checkbox" class="checkbox cb cb1 update_is_active"
                                                       type="checkbox" name="is_active" value="1"
                                                       data-id="{{ $category->id }}"
                                                    {{ $category->is_active == 1 ? 'checked' : '' }} />
                                                <i></i>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="checkbox-label">
                                                <input id="checkbox2" class="checkbox cb cb1 update_is_new"
                                                       type="checkbox" name="is_new" value="1"
                                                       data-id="{{ $category->id }}"
                                                    {{ $category->is_new == 1 ? 'checked' : '' }} />
                                                <i></i>
                                            </label>
                                        </td>
                                        <td>
                                            <div class="card-tools">
                                                <a href="{{ route('admin.categories.editSeo', ['category' => $category]) }}"
                                                   title="@lang('messages.seo')"
                                                   class="btn btn-info btn-sm">
                                                    @lang('messages.seo')
                                                </a>
                                                <a href="{{ route('admin.categories.edit', ['category' => $category]) }}"
                                                   title="@lang('messages.edit')"
                                                   class="btn btn-primary btn-sm">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <form method="POST" class="d-inline"
                                                      action="{{ route('admin.categories.destroy', ['category' => $category]) }}">
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
                                        <td align="center" class="text-danger p-2" colspan="4">
                                            Категорий не найдены
                                        </td>
                                    </tr>
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

@push('scripts')
    <script>
        $('.update_is_active').click(function (e) {
            let dataId = $(this).attr('data-id')
            const _token = $('meta[name="csrf-token"]').attr('content');

            if ($(this).prop('checked')) {
                $.ajax({
                    method: "POST",
                    url: `/admin/categories/${dataId}/updateIsActive`,
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
                    url: `/admin/categories/${dataId}/updateIsActive`,
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

        $('.update_is_new').click(function (e) {
            let dataId = $(this).attr('data-id')
            const _token = $('meta[name="csrf-token"]').attr('content');

            if ($(this).prop('checked')) {
                $.ajax({
                    method: "POST",
                    url: `/admin/categories/${dataId}/updateIsNew`,
                    data: {
                        _token: _token,
                        is_new: 1,
                        data_id: dataId,
                    },
                    success: (response) => {
                        console.log(response.status)
                    }
                })
            } else {
                $.ajax({
                    method: "POST",
                    url: `/admin/categories/${dataId}/updateIsNew`,
                    data: {
                        _token: _token,
                        is_new: 0,
                        data_id: dataId,
                    },
                    success: (response) => {
                        console.log(response.status)
                    }
                })
            }
        });
    </script>
@endpush
