@extends('layouts.admin')

@section('title', trans('messages.edit'))

@section('content')
    <div class="content-header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <a href="{{ route('admin.deliveryContents.index') }}" title="@lang('messages.back')"
                       class="btn btn-warning btn-sm mb-1 mr-3">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i>
                        @lang('messages.back')
                    </a>
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
                    <a href="{{ route('admin.deliveryContents.index') }}" title="@lang('messages.back')"
                       class="btn btn-warning btn-sm mb-3">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i>
                        @lang('messages.back')
                    </a>
                    <div class="info-box flex-column shadow-none">
                        <form method="POST" class="form-horizontal" enctype="multipart/form-data"
                              action="{{ route('admin.deliveryContents.update', ['deliveryContent' => $deliveryContent]) }}">
                            @csrf
                            @method('PATCH')
                            @include('admin.deliveryContents._form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    @includeIf('admin._components.formTabs')
    @includeIf('admin._components.ckeditor4Scripts', ['height' => 300])
@endpush
