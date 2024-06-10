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
                        <form method="POST" class="form-horizontal" enctype="multipart/form-data"
                              action="{{ route('admin.homeContents.update', ['homeContent' => $homeContent]) }}">
                            @csrf
                            @method('PATCH')
                            @include('admin.homeContents._form')
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
@endpush
