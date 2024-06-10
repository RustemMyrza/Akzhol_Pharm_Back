@extends('layouts.admin')

@section('title', trans('messages.add'))

@push('styles')
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
                    <h5 class="m-0">@lang('messages.add')</h5>
                </div>
            </div>
        </div>
    </div>

    <section class="content ">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <a class="btn btn-warning mb-3" href="{{ route('admin.orders.index') }}"
                       title="@lang('messages.back')">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i>
                        @lang('messages.back')
                    </a>
                </div>

                @include('admin._components.alert')

                <div class="col-12 col-lg-12">
                    <div class="info-box flex-column shadow-none">
                        <form method="POST" action="{{ route('admin.orders.store') }}"
                              autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            @include('admin.orders._form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    @include('admin._components.select2Scripts')
    <script>
        $('.trigger').change(function () {
            $('.content-type').hide();
            $('.content-type-' + $('.trigger:checked').data('rel')).show();
        }).change();
    </script>
@endpush
