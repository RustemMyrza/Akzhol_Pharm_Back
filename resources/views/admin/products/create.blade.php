@extends('layouts.admin')

@section('title', trans('messages.add'))

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <a href="{{ route('admin.products.index') }}" title="@lang('messages.back')"
                       class="btn btn-warning btn-sm mb-1 mr-3">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i>
                        @lang('messages.back')
                    </a>
                    <h5 class="m-0 d-inline-block">@lang('messages.add') </h5>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                @include('admin._components.alert')

                <div class="col-12">

                    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="info-box flex-column shadow-none">
                                    @include('admin.products._form_left')
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mb-0">
                                        <button type="submit" class="btn btn-primary">
                                            @lang('messages.save')
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="info-box flex-column shadow-none">
                                    @include('admin.products._form_right')
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    @includeIf('admin._components.loadFileScript')
    @includeIf('admin._components.formTabs')
    @includeIf('admin._components.customFileInput')
    @includeIf('admin._components.select2Scripts')
    @includeIf('admin._components.ckeditor4Scripts')
    <script>
        $(document).ready(function () {
            $('.checkbox').change(function () {
                updateButtonLabel($(this));
            }).change();

            function updateButtonLabel(checkbox) {
                const isChecked = checkbox.is(':checked');
                const buttonLabel = isChecked ? 'Показать' : 'Не показать';

                const span = checkbox.closest('.form-group').find('span');
                span.text(buttonLabel);
            }
        });

        $('#category_id').change(function () {
            let categoryId = $('#category_id :selected').val();

            $.ajax({
                method: "GET",
                url: `/admin/get-filters?category_id=${categoryId}`,
                success: (response) => {
                    $('#product_filter_items').html(response);
                    $('#product_filter_items').select2();
                },
                error: (error) => {
                    console.log(error);
                }
            })
        })

        $('#category_id').change(function () {
            let categoryId = $('#category_id :selected').val();

            $.ajax({
                method: "GET",
                url: `/admin/get-subCategories?category_id=${categoryId}`,
                success: (response) => {
                    $('#sub_category_id').html(response);
                    $('#sub_category_id').select2();
                },
                error: (error) => {
                    console.log(error);
                }
            })
        }).change()
    </script>
@endpush
