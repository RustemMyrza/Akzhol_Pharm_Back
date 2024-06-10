@extends('layouts.admin')

@section('title', trans('messages.add'))

@section('content')
    <div class="content-header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h5 class="m-0">@lang('messages.add') </h5>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container">
            <div class="row">
                @include('admin._components.alert')

                <div class="col-12">
                    <a href="{{ route('admin.aboutUsContents.index') }}" title="@lang('messages.back')"
                       class="btn btn-warning btn-sm mb-3">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i>
                        @lang('messages.back')
                    </a>
                    <div class="info-box flex-column shadow-none">
                        <form method="POST" action="{{ route('admin.aboutUsContents.store') }}" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            @include('admin.aboutUsContents._form')
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
@endpush
