@extends('layouts.admin')

@section('title', trans('messages.edit'))

@section('content')
    <div class="content-header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h5 class="m-0">@lang('messages.edit')</h5>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container">
            <div class="row">
                @include('admin._components.alert')
                <div class="col-12">
                    <div class="info-box flex-column shadow-none">
                        <form method="POST" enctype="multipart/form-data"
                              action="{{ route('admin.paymentContent.update', ['paymentContent' => $paymentContent]) }}">
                            @csrf
                            @method('PATCH')
                            @include('admin.paymentContent._form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    @includeIf('admin._components.formTabs')
    @includeIf('admin._components.ckeditor4Scripts')
    @includeIf('admin._components.loadFileScript')
    <script>
        $('#deleteImage').on('click', function () {
            let dataId = $(this).attr('data-id')
            const _token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                method: "POST",
                url: `/admin/paymentContent/${dataId}/deleteImage`,
                data: {
                    _token: _token,
                },
                success: (response) => {
                    if (response.data.status) {
                        location.reload()
                    }
                }
            })
        })
    </script>
@endpush
