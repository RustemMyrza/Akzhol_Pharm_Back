@extends('layouts.admin')

@section('title', 'Меню / SEO страницы')

@section('content')
    <div class="content-header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h5 class="m-0">Меню / SEO страницы</h5>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container">
            @include('admin._components.alert')

            <div class="card-tools mb-4 @if(!authHasRole()) d-none @endif">
                <a href="{{ route('admin.seoPages.create') }}" class="btn btn-primary"
                   title="@lang('messages.add')">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                    @lang('messages.add')
                </a>
            </div>

            @if(count($seoPages))
                <div class="info-box info-card flex-column shadow-none">
                    <div class="table-responsive" id="for_sort">
                        <table class="table table-hover" >
                            <thead class="thead">
                            <tr>
                                <th>#ID</th>
                                <th>@lang('validation.attributes.title')</th>
                                <th class="@if(!authHasRole()) d-none @endif">Страница</th>
                                <th>@lang('validation.attributes.status')</th>
                                <th>Время обновления</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($seoPages as $seoPage)
                                <tr>
                                    <td  data-original-id="{{ $seoPage->id }}" data-id="{{ $seoPage->id }}">{{ $seoPage->id }}</td>
                                    <td>{{ $seoPage->titleTranslate?->{app()->getLocale()} }}</td>
                                    <td class="@if(!authHasRole()) d-none @endif">{{ $seoPage->page }}</td>
                                    <td>
                                        <label class="checkbox-label">
                                            <input id="checkbox" class="checkbox cb cb1 update_is_active"
                                                   type="checkbox" name="is_active" value="1"
                                                   data-id="{{ $seoPage->id }}"
                                                {{ $seoPage->is_active == 1 ? 'checked' : '' }} />
                                            <i></i>
                                        </label>
                                    </td>
                                    <td>{{ $seoPage->updated_at_format }}</td>
                                    <td>
                                        <div class="card-tools">
                                            <a href="{{ route('admin.seoPages.edit', ['seoPage' => $seoPage]) }}"
                                               title="@lang('messages.edit')" class="btn btn-primary btn-sm">
                                                @lang('messages.edit')
                                            </a>
                                            <form method="POST"
                                                  action="{{ route('admin.seoPages.destroy', ['seoPage' => $seoPage]) }}"
                                                  style="display:inline" class="@if(!authHasRole()) d-none @endif">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="btn btn-danger"
                                                        onclick="return confirm('@lang('messages.confirm_deletion')')">
                                                    @lang('messages.delete')
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="alert alert-danger alert-dismissible border-0">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <p class="m-0"><i class="icon fas fa-ban"></i> Меню / SEO страницы не найдены</p>
                </div>
            @endif

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
                    url: `/admin/seoPages/${dataId}/updateIsActive`,
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
                    url: `/admin/seoPages/${dataId}/updateIsActive`,
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
