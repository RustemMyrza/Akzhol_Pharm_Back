@extends('layouts.admin')

@section('title', trans('messages.edit'))

@push('styles')
    @includeIf('admin._components.summernoteStyles')
    <style>
        .content-type {
            display: none;
        }
    </style>
@endpush

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
                <div class="col-12">
                    @include('admin._components.alert')

                    <div class="card-tools mb-3">
                        <a href="{{ route('admin.notificationMessages.index') }}"
                           class="btn btn-warning btn-sm" title="@lang('messages.back')">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i>
                            @lang('messages.back')
                        </a>
                    </div>

                    <div class="info-box flex-column shadow-none">
                        <form method="POST"
                              action="{{ route('admin.notificationMessages.update', $notificationMessage) }}"
                              enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            @include('admin.notificationMessages._form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    @includeIf('admin._components.loadFileScript')
    @includeIf('admin._components.ckeditor4Scripts')
    @includeIf('admin._components.select2Scripts')
    <script>

        $(document).ready(function () {
            $('.type').change(function () {
                let $selectValue = $('.type').val();

                if ($selectValue === '0') {
                    $('.content-type-1').hide()
                    $('.content-type-' + $selectValue).show()
                } else if ($selectValue === '1') {
                    $('.content-type-0').hide()
                    $('.content-type-' + $selectValue).show()
                    $('#user_ids_select').empty();

                    $.ajax({
                        type: 'GET',
                        url: '/admin/get-users',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: 'json',
                        success: function (data) {
                            $('#user_ids_select').empty();

                            $.each(data.users, function (index, user) {
                                $('#user_ids_select').append('<option value="' + user.id + '">' + user.name + '</option>');
                            });
                        },
                        error: function (xhr) {
                            $('#user_ids_select').empty();

                            Swal.fire({
                                text: `${xhr.responseJSON?.message}`,
                                type: 'warning',
                                icon: 'warning',
                                showCloseButton: true,
                            })
                        }
                    });
                }
            }).change();
        });

        $('#course_id').on('change', function () {
            let courseId = $(this).val();

            $.ajax({
                type: 'GET',
                url: `/admin/courses/${courseId}/users`,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function (data) {
                    $('#user_ids_select').empty();

                    $.each(data.users, function (index, user) {
                        $('#user_ids_select').append('<option selected value="' + user.id + '">' + user.name + '</option>');
                    });
                },
                error: function (xhr) {
                    $('#user_ids_select').empty();

                    Swal.fire({
                        text: `${xhr.responseJSON?.message}`,
                        type: 'warning',
                        icon: 'warning',
                        showCloseButton: true,
                    })
                }
            });
        }).change();
    </script>
@endpush
