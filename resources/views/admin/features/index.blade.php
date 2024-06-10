@extends('layouts.admin')

@section('title', 'Характеристики')

@section('content')
    <div class="content-header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h5 class="m-0">Характеристики</h5>
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
                        <a href="{{ route('admin.features.create') }}"
                           class="btn btn-primary btn-sm mr-1 mb-2 mb-sm-0" title="@lang('messages.add')">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                            @lang('messages.add')
                        </a>
                    </div>

                    <div class="info-box info-card flex-column shadow-none">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="thead">
                                <tr>
                                    <th>#ID</th>
                                    <th>@lang('validation.attributes.title')</th>
                                    <th>Тип</th>
                                    <th>Значений</th>
                                    <th>@lang('validation.attributes.status')</th>
                                    <th></th>
                                </tr>
                                </thead>

                                <tbody>
                                @forelse($features as $feature)
                                    <tr>
                                        <td>{{ $feature->id }}</td>
                                        <td>{{ $feature->titleTranslate?->ru }}</td>
                                        <td>{{ $feature->type_name }}</td>
                                        <td>
                                            <a href="{{ route('admin.featureItems.index', ['feature' => $feature]) }}"
                                               class="default-link">
                                                Список значений ({{ $feature->feature_items_count }})
                                            </a>
                                        </td>
                                        <td>
                                            <label class="checkbox-label">
                                                <input id="checkbox" class="checkbox cb cb1 update_is_active"
                                                       type="checkbox" name="is_active" value="1"
                                                       data-id="{{ $feature->id }}"
                                                    {{ $feature->is_active == 1 ? 'checked' : '' }} />
                                                <i></i>
                                            </label>
                                        </td>
                                        <td>
                                            <div class="card-tools">

                                                <a href="{{ route('admin.features.edit', ['feature' => $feature]) }}"
                                                   title="@lang('messages.edit')"
                                                   class="btn btn-primary btn-sm">
                                                    @lang('messages.edit')
                                                </a>
                                                <form method="POST" class="d-inline"
                                                      action="{{ route('admin.features.destroy', ['feature' => $feature]) }}">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                            title="@lang('messages.delete')"
                                                            onclick="return confirm('@lang('messages.confirm_deletion')')">
                                                        @lang('messages.delete')
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td align="center" class="text-danger p-2" colspan="5">
                                            Характеристики не найдены
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>

                            <div class="pagination-wrapper">
                                {!! $features->appends(['search' => request('search')])->render() !!}
                            </div>
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
                    url: `/admin/features/${dataId}/updateIsActive`,
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
                    url: `/admin/features/${dataId}/updateIsActive`,
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
    </script>
@endpush
