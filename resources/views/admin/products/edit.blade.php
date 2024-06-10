@extends('layouts.admin')
@section('title', trans('messages.edit'))
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
                    <h5 class="m-0 d-inline-block default-link"> {{ $product->titleTranslate?->ru  }}</h5>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                @include('admin._components.alert')
                <div class="col-12">
                    <form method="POST" class="form-horizontal" enctype="multipart/form-data"
                          action="{{ route('admin.products.update', ['product' => $product]) }}">
                        @csrf
                        @method('PATCH')
                        <input id="product_id" type="hidden" value="{{ $product->id }}">

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

                    @includeIf('admin.products._addDescriptionList')
                    @includeIf('admin.products._editDescriptionList')

                    @includeIf('admin.products._addInstructionList')
                    @includeIf('admin.products._editInstructionList')
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
    @includeIf('admin._components.ckeditor4Scripts', ['height' => 400])
    <script src="{{ asset('adminlte-assets/dist/js/product/default.js') }}"></script>
{{--    <script src="{{ asset('adminlte-assets/dist/js/product/add-description-list.js') }}"></script>--}}
{{--    <script src="{{ asset('adminlte-assets/dist/js/product/add-instruction-list.js') }}"></script>--}}
@endpush
