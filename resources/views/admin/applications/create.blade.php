@extends('layouts.admin')

@section('title', trans('messages.add'))

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
                    <a class="btn btn-warning mb-3" href="{{ route('admin.applications.index') }}"
                       title="@lang('messages.back')">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i>
                        @lang('messages.back')
                    </a>
                </div>

                @include('admin._components.alert')

                <div class="col-12 col-lg-12">
                    <div class="info-box flex-column shadow-none">
                        <form method="POST" action="{{ route('admin.applications.store') }}"
                              autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            @include('admin.applications._form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    @include('admin._components.select2Scripts')
@endpush
