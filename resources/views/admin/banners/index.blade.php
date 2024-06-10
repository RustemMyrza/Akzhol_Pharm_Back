@extends('layouts.admin')

@section('title', trans('messages.banner'))

@section('content')
    <div class="content-header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h5 class="m-0">@lang('messages.banner')</h5>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container">
            <div class="row">
                @include('admin._components.alert')
                <div class="col-12">
                    <div class="card-tools mb-4">
                        <a href="{{ route('admin.banners.create') }}"
                           class="btn btn-primary" title="@lang('messages.add')">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                            @lang('messages.add')
                        </a>
                    </div>

                    @if(count($banners))
                        <div class="info-box info-card shadow-none">
                            <div class="table-responsive" id="for_sort">
                                <table class="table table-hover">
                                    <thead class="thead">
                                    <tr>
                                        <th>#ID</th>
                                        <th>@lang('validation.attributes.image') Desktop</th>
                                        <th>@lang('validation.attributes.image') Mobile</th>
                                        <th>@lang('validation.attributes.status')</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($banners as $banner)
                                        <tr>
                                            <td data-original-id="{{ $banner->id }}" data-id="{{ $banner->id }}">
                                                {{ $banner->id }}
                                            </td>
                                            <td>
                                                <img src="{{ $banner->imageUrl($banner->imageTranslate) }}" class="rounded banner-index-image">
                                            </td>
                                            <td>
                                                <img src="{{ $banner->imageUrl($banner->mobileImageTranslate) }}" class="rounded banner-index-image">
                                            </td>
                                            <td>
                                                <label class="checkbox-label">
                                                    <input id="checkbox" class="checkbox cb cb1 update_is_active"
                                                           type="checkbox" name="is_active" value="1"
                                                           data-id="{{ $banner->id }}"
                                                        {{ $banner->is_active == 1 ? 'checked' : '' }} />
                                                    <i></i>
                                                </label>
                                            </td>
                                            <td>
                                                <div class="card-tools">
                                                    <a href="{{ route('admin.banners.edit', ['banner' => $banner]) }}"
                                                       title="@lang('messages.edit')"
                                                       class="btn btn-primary">
                                                        @lang('messages.edit')
                                                    </a>

                                                    <form method="POST" class="d-inline"
                                                          action="{{ route('admin.banners.destroy', ['banner' => $banner]) }}">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger"
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
                                            <td align="center" class="text-danger p-2" colspan="4">
                                                @lang('messages.banners_not_found')
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-danger alert-dismissible border-0">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <p class="m-0"><i class="icon fas fa-ban"></i> @lang('messages.banners_not_found')</p>
                        </div>
                    @endif
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
                    url: `/admin/banners/${dataId}/updateIsActive`,
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
                    url: `/admin/banners/${dataId}/updateIsActive`,
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
