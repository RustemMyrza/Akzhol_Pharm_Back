@extends('layouts.admin')

@section('title', 'Заполнить SEO')

@section('content')
    <div class="content-header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h5 class="m-0">Заполнить SEO</h5>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container">
            <div class="row">
                @include('admin._components.alert')

                <div class="col-12">
                    <a class="btn btn-warning mb-4" href="{{ route('admin.seoPages.index') }}"
                       title="@lang('messages.back')">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i>
                        @lang('messages.back')
                    </a>

                    <div class="info-box flex-column shadow-none">
                        <form method="POST" action="{{ route('admin.seoPages.store') }}" >
                            @csrf
                            @method('POST')
                            @include('admin.seoPages._form', ['type' => 'create'])
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    @includeIf('admin._components.formTabs')
@endpush
