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
                    <a href="{{ route('admin.agreements.index') }}" title="@lang('messages.back')"
                       class="btn btn-warning btn-sm mb-3">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i>
                        @lang('messages.back')
                    </a>

                    <div class="info-box flex-column shadow-none">
                        <form method="POST" enctype="multipart/form-data"
                              action="{{ route('admin.agreements.update', ['agreement' => $agreement]) }}">
                            @csrf
                            @method('PATCH')
                            @include('admin.agreements._form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    @include('admin._components.select2Scripts')
    @include('admin._components.formTabs')
    @include('admin._components.customFileInput')
@endpush
