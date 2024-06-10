@extends('layouts.admin')

@section('title', 'Доставка')

@push('styles')
    <style>
        .h2, h2 {
            font-size: 1rem;
        }
    </style>
@endpush

@section('content')
    {{--    <div class="content-header">--}}
    {{--        <div class="container">--}}
    {{--            <div class="row">--}}
    {{--                <div class="col-12">--}}
    {{--                    <h5 class="m-0">Доставка особенности</h5>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}

    <section class="content">
        <div class="container">
            <div class="row">
                @include('admin._components.alert')

                @includeIf('admin.deliveryFeatures.indexComponent')

                @includeIf('admin.deliveryLists.indexComponent')

                <div class="col-12">
                    <h5 class="mb-3">Доставка контент</h5>
                </div>

                <div class="col-12">
                    @if(!count($deliveryContents))
                        <div class="card-tools flex-wrap justify-content-between mb-2 mb-md-3">
                            <a href="{{ route('admin.deliveryContents.create') }}"
                               class="btn btn-success btn-sm" title="@lang('messages.add')">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                                @lang('messages.add')
                            </a>
                        </div>
                    @endif

                    <div class="info-box info-card flex-column shadow-none">
                        <div class="table-responsive">
                            <table class="table table-hover not-styles">
                                <thead class="thead">
                                <tr>
                                    <th>@lang('validation.attributes.title')</th>
                                    <th>@lang('validation.attributes.description')</th>
                                    <th></th>
                                </tr>
                                </thead>

                                <tbody>
                                @forelse($deliveryContents as $deliveryContent)
                                    <tr>
                                        <td style="white-space: normal">{!! $deliveryContent->descriptionTranslate?->ru !!}</td>
                                        <td style="white-space: normal">{!! $deliveryContent->contentTranslate?->ru !!}</td>
                                        <td>
                                            <div class="card-tools">
                                                <a href="{{ route('admin.deliveryContents.edit', ['deliveryContent' => $deliveryContent]) }}"
                                                   title="@lang('messages.edit')"
                                                   class="btn btn-primary btn-sm">
                                                    @lang('messages.edit')
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td align="center" class="text-danger p-2" colspan="3">
                                            Доставка контент не найдено
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
        $('.update_is_active_1').click(function (e) {
            let dataId = $(this).attr('data-id')
            const _token = $('meta[name="csrf-token"]').attr('content');

            if ($(this).prop('checked')) {
                $.ajax({
                    method: "POST",
                    url: `/admin/deliveryFeatures/${dataId}/updateIsActive`,
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
                    url: `/admin/deliveryFeatures/${dataId}/updateIsActive`,
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
        $('.update_is_active_2').click(function (e) {
            let dataId = $(this).attr('data-id')
            const _token = $('meta[name="csrf-token"]').attr('content');

            if ($(this).prop('checked')) {
                $.ajax({
                    method: "POST",
                    url: `/admin/deliveryLists/${dataId}/updateIsActive`,
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
                    url: `/admin/deliveryLists/${dataId}/updateIsActive`,
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