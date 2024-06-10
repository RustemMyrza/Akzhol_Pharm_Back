@extends('layouts.admin')

@section('title', 'Способ оплаты')

@section('content')
    <div class="content-header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h5 class="m-0">Способ оплаты</h5>
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
                        <a href="{{ route('admin.paymentMethods.create') }}"
                           class="btn btn-primary" title="@lang('messages.add')">
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
                                    <th>@lang('validation.attributes.description')</th>
                                    <th>@lang('validation.attributes.status')</th>
                                    <th></th>
                                </tr>
                                </thead>

                                <tbody>
                                @forelse($paymentMethods as $paymentMethod)
                                    <tr>
                                        <td data-original-id="{{ $paymentMethod->id }}" data-id="{{ $paymentMethod->id }}">{{ $paymentMethod->id }}</td>
                                        <td>
                                            <img src="{{ $paymentMethod->image_url }}" class="rounded payment-method-index-image">
                                        </td>
                                        <td>{{ miniText($paymentMethod->titleTranslate?->ru, 50) }}</td>
                                        <td>{{ miniText($paymentMethod->descriptionTranslate?->ru, 50) }}</td>
                                        <td>
                                            <label class="checkbox-label">
                                                <input id="checkbox" class="checkbox cb cb1 update_is_active"
                                                       type="checkbox" name="is_active" value="1"
                                                       data-id="{{ $paymentMethod->id }}"
                                                    {{ $paymentMethod->is_active == 1 ? 'checked' : '' }} />
                                                <i></i>
                                            </label>
                                        </td>
                                        <td>
                                            <div class="card-tools">
                                                <a href="{{ route('admin.paymentMethods.edit', ['paymentMethod' => $paymentMethod]) }}"
                                                   title="@lang('messages.edit')"
                                                   class="btn btn-primary btn-sm">
                                                    @lang('messages.edit')
                                                </a>
                                                <form method="POST" class="d-inline"
                                                      action="{{ route('admin.paymentMethods.destroy', ['paymentMethod' => $paymentMethod]) }}">
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
                                            Способ оплаты не найдены
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
                    url: `/admin/paymentMethods/${dataId}/updateIsActive`,
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
                    url: `/admin/paymentMethods/${dataId}/updateIsActive`,
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
