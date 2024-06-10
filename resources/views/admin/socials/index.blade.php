@extends('layouts.admin')

@section('title', trans('messages.socials'))

@section('content')
    <div class="content-header">
        <div class="container">
            <h5 class="m-0">@lang('messages.socials')</h5>
        </div>
    </div>

    <section class="content">
        <div class="container">
            <div class="row">
                @include('admin._components.alert')
                <div class="col-12">
                    <div class="card-tools mb-4">
                        <a href="{{ route('admin.socials.create') }}"
                           class="btn btn-primary" title="@lang('messages.add')">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                            @lang('messages.add')
                        </a>
                    </div>

                    @if(count($socials))
                        <div class="info-box info-card flex-column shadow-none">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="thead">
                                    <tr>
                                        <th>#ID</th>
                                        <th>@lang('validation.attributes.icon')</th>
                                        <th>@lang('validation.attributes.link')</th>
                                        <th>@lang('validation.attributes.status')</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($socials as $social)
                                        <tr>
                                            <td>{{ $social->id }}</td>
                                            <td>
                                                <img src="{{ $social->image_url }}" class="rounded social-index-image">
                                            </td>
                                            <td>
                                                <a href="{{ $social->link }}">{{ $social->link }}</a>
                                            </td>
                                            <td>
                                                <label class="checkbox-label">
                                                    <input id="checkbox" class="checkbox cb cb1 update_is_active"
                                                           type="checkbox" name="is_active" value="1"
                                                           data-id="{{ $social->id }}"
                                                        {{ $social->is_active == 1 ? 'checked' : '' }} />
                                                    <i></i>
                                                </label>
                                            </td>
                                            <td>
                                                <div class="card-tools">
                                                    <a href="{{ route('admin.socials.edit', ['social' => $social]) }}"
                                                       title="@lang('messages.edit')"
                                                       class="btn btn-primary btn-sm">
                                                        @lang('messages.edit')
                                                    </a>

                                                    <form method="POST" class="d-inline"
                                                          action="{{ route('admin.socials.destroy', ['social' => $social]) }}">
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
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-danger alert-dismissible border-0">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <p class="m-0"><i class="icon fas fa-ban"></i>
                                @lang('messages.socials_not_found')
                            </p>
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
                    url: `/admin/socials/${dataId}/updateIsActive`,
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
                    url: `/admin/socials/${dataId}/updateIsActive`,
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
