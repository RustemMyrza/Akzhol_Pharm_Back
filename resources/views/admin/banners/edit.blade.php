@extends('layouts.admin')

@section('title', trans('messages.edit'))

@section('content')
    <div class="content-header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <a href="{{ route('admin.banners.index') }}" title="@lang('messages.back')"
                       class="btn btn-warning btn-sm mb-1 mr-3">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i>
                        @lang('messages.back')
                    </a>
                    <h5 class="m-0">@lang('messages.edit') </h5>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container">
            <div class="row">
                @include('admin._components.alert')

                <div class="col-12">
                    <a href="{{ route('admin.banners.index') }}" title="@lang('messages.back')"
                       class="btn btn-warning mb-3">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i>
                        @lang('messages.back')
                    </a>
                    <div class="info-box flex-column shadow-none">
                        <form method="POST" enctype="multipart/form-data"
                              action="{{ route('admin.banners.update', ['banner' => $banner]) }}">
                            @csrf
                            @method('PATCH')
                            @include('admin.banners._form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    @includeIf('admin._components.loadFileScript')
    @includeIf('admin._components.formTabs')
@endpush
