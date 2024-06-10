@extends('layouts.admin')

@section('title', 'Документация')

@section('content')
    <div class="content-header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h5 class="m-0">Отзывы</h5>
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
                        <div class="card-tools">
                            <a href="{{ route('admin.instructions.create') }}"
                               class="btn btn-primary" title="@lang('messages.add')">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                                @lang('messages.add')
                            </a>
                        </div>
                        <div class="d-flex justify-content-end">
                            <form method="GET" class="search-form" action="{{ route('admin.instructions.index') }}">
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
                        <div class="table-responsive" id="for_sort">
                            <table class="table table-hover">
                                <thead class="thead">
                                <tr>
                                    <th>#ID</th>
                                    <th>ФИО</th>
                                    <th>Оценка</th>
                                    <th>Описание</th>
                                    <th>@lang('validation.attributes.status')</th>
                                    <th></th>
                                </tr>
                                </thead>

                                <tbody>
                                @forelse($instructions as $instruction)
                                    <tr>
                                        <td data-original-id="{{ $instruction->id }}"
                                            data-id="{{ $instruction->id }}">{{ $instruction->id }}</td>
                                        <td style="white-space: normal">
                                            <img src="{{ $instruction->image_url }}" class="rounded instruction-index-image" alt="">
                                            {{ $instruction->titleTranslate?->ru }}
                                        </td>
                                        <td>
                                            @if($instruction->fileUrl($instruction->fileTranslate))
                                                <a href="{{ $instruction->fileUrl($instruction->fileTranslate, app()->getLocale()) }}">
                                                    @lang('messages.download')
                                                    ({{ app()->getLocale() }})</a>
                                            @else
                                                @lang('messages.document_not_attached')
                                            @endif
                                        </td>
                                        <td>
                                            @if($instruction->fileUrl($instruction->fileTranslate))
                                                {{ fileSizeFormat($instruction->fileTranslate?->{app()->getLocale(). '_size'}) }}
                                            @else
                                                @lang('messages.document_not_attached')
                                            @endif
                                        </td>
                                        <td>
                                            <label class="checkbox-label">
                                                <input id="checkbox" class="checkbox cb cb1 update_is_active"
                                                       type="checkbox" name="is_active" value="1"
                                                       data-id="{{ $instruction->id }}"
                                                    {{ $instruction->is_active == 1 ? 'checked' : '' }} />
                                                <i></i>
                                            </label>
                                        </td>
                                        <td>
                                            <div class="card-tools">
                                                <a href="{{ route('admin.instructions.edit', ['instruction' => $instruction]) }}"
                                                   title="@lang('messages.edit')"
                                                   class="btn btn-primary btn-sm">
                                                    @lang('messages.edit')
                                                </a>
                                                <form method="POST" class="d-inline"
                                                      action="{{ route('admin.instructions.destroy', ['instruction' => $instruction]) }}">
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
                                        <td align="center" class="text-danger p-2" colspan="7">
                                            Отзывы не найдены
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>

                            <div class="pagination-wrapper">
                                {!! $instructions->appends(['search' => request('search')])->render() !!}
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
                    url: `/admin/instructions/${dataId}/updateIsActive`,
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
                    url: `/admin/instructions/${dataId}/updateIsActive`,
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
